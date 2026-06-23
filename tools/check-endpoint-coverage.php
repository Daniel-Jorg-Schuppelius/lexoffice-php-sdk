#!/usr/bin/env php
<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : check-endpoint-coverage.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

/**
 * Script to check SDK endpoint coverage against Postman API collection
 *
 * Usage: php scripts/check-endpoint-coverage.php [path-to-postman-collection.json]
 */
$defaultPostmanPath = __DIR__ . '/../docs/lexoffice-API-Samples.postman_collection.json';
$postmanPath = $argv[1] ?? $defaultPostmanPath;

if (!file_exists($postmanPath)) {
    echo "Error: Postman collection not found at: $postmanPath\n";
    echo "Usage: php scripts/check-endpoint-coverage.php [path-to-postman-collection.json]\n";
    exit(1);
}

// Load Postman collection
$postmanJson = file_get_contents($postmanPath);
$postman = json_decode($postmanJson, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error: Invalid JSON in Postman collection\n";
    exit(1);
}

/**
 * Extract all API endpoints from Postman collection recursively
 */
function extractPostmanEndpoints(array $items, string $prefix = ''): array {
    $endpoints = [];

    foreach ($items as $item) {
        $name = $prefix ? "$prefix / {$item['name']}" : $item['name'];

        if (isset($item['item'])) {
            // This is a folder, recurse
            $endpoints = array_merge($endpoints, extractPostmanEndpoints($item['item'], $name));
        } elseif (isset($item['request'])) {
            // This is a request
            $request = $item['request'];
            $method = is_string($request['method']) ? $request['method'] : 'GET';

            // Extract URL path
            $url = $request['url'];
            $path = '';
            $queryParams = [];
            if (is_array($url)) {
                if (isset($url['path'])) {
                    $path = '/' . implode('/', $url['path']);
                }
                // Extract query parameters
                if (isset($url['query'])) {
                    foreach ($url['query'] as $param) {
                        if (!isset($param['disabled']) || !$param['disabled']) {
                            $queryParams[] = $param['key'];
                        }
                    }
                }
            } elseif (is_string($url)) {
                $parsed = parse_url($url);
                $path = $parsed['path'] ?? $url;
            }

            // Normalize path (remove version prefix)
            $path = preg_replace('#^/v1/#', '/', $path);

            // Detect special actions from path
            $action = null;
            if (preg_match('#/document$#', $path)) {
                $action = 'render';
            } elseif (preg_match('#/sendmail$#', $path)) {
                $action = 'sendMail';
            }

            // Detect pursue from query params
            if (in_array('precedingSalesVoucherId', $queryParams)) {
                $action = 'pursue';
            }

            // Detect finalize
            $hasFinalize = in_array('finalize', $queryParams);

            $endpoints[] = [
                'name' => $item['name'],
                'folder' => $prefix,
                'method' => strtoupper($method),
                'path' => $path,
                'action' => $action,
                'hasFinalize' => $hasFinalize,
                'queryParams' => $queryParams,
            ];
        }
    }

    return $endpoints;
}

/**
 * Scan SDK endpoint files and extract implemented methods
 */
function scanSdkEndpoints(string $srcPath): array {
    $endpoints = [];
    $endpointPath = $srcPath . '/API/Endpoints';

    if (!is_dir($endpointPath)) {
        return $endpoints;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($endpointPath, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $content = file_get_contents($file->getPathname());
        $className = $file->getBasename('.php');

        // Extract endpoint name from class
        preg_match('/protected\s+string\s+\$endpoint\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $endpointMatch);
        $endpointName = $endpointMatch[1] ?? strtolower(str_replace('Endpoint', '', $className));

        // Extract public methods with their signatures
        preg_match_all('/public\s+function\s+(\w+)\s*\([^)]*\)/', $content, $methodMatches);
        $methods = $methodMatches[1] ?? [];

        // Check if class extends DocumentEndpointAbstract (has render() method inherited)
        $extendsDocumentEndpoint = (bool) preg_match('/extends\s+DocumentEndpointAbstract/', $content);
        if ($extendsDocumentEndpoint && !in_array('render', $methods)) {
            $methods[] = 'render';
        }

        // Check for finalize parameter in create method
        $hasCreateFinalize = (bool) preg_match('/public\s+function\s+create\s*\([^)]*bool\s+\$finalize/', $content);

        // Map method names to HTTP methods and actions
        $methodMapping = [
            'get' => ['http' => 'GET', 'action' => 'get'],
            'create' => ['http' => 'POST', 'action' => 'create'],
            'update' => ['http' => 'PUT', 'action' => 'update'],
            'delete' => ['http' => 'DELETE', 'action' => 'delete'],
            'search' => ['http' => 'GET', 'action' => 'search'],
            'list' => ['http' => 'GET', 'action' => 'list'],
            'render' => ['http' => 'GET', 'action' => 'render'],
            'pursue' => ['http' => 'POST', 'action' => 'pursue'],
            'sendMail' => ['http' => 'POST', 'action' => 'sendMail'],
            'upload' => ['http' => 'POST', 'action' => 'upload'],
            'download' => ['http' => 'GET', 'action' => 'download'],
        ];

        foreach ($methods as $method) {
            // Skip constructor and inherited methods
            if (in_array($method, ['__construct', 'getEndpointUrl', 'setLogger'])) {
                continue;
            }

            $mapping = $methodMapping[$method] ?? ['http' => 'UNKNOWN', 'action' => $method];

            $endpoints[] = [
                'class' => $className,
                'endpoint' => $endpointName,
                'method' => $method,
                'httpMethod' => $mapping['http'],
                'action' => $mapping['action'],
                'hasCreateFinalize' => $hasCreateFinalize,
            ];
        }
    }

    return $endpoints;
}

/**
 * Normalize endpoint path for comparison
 */
function normalizePath(string $path): string {
    // Remove IDs and query parameters
    $path = preg_replace('/\/:?\w+Id/', '/{id}', $path);
    $path = preg_replace('/\/[a-f0-9-]{36}/', '/{id}', $path);
    $path = preg_replace('/\?.*$/', '', $path);
    $path = rtrim($path, '/');
    return strtolower($path);
}

/**
 * Group endpoints by resource
 */
function groupByResource(array $endpoints): array {
    $grouped = [];
    foreach ($endpoints as $endpoint) {
        $path = $endpoint['path'];
        // Extract resource name (first path segment)
        preg_match('#^/([^/]+)#', $path, $match);
        $resource = $match[1] ?? 'unknown';
        $grouped[$resource][] = $endpoint;
    }
    ksort($grouped);
    return $grouped;
}

// Extract endpoints
$postmanEndpoints = extractPostmanEndpoints($postman['item'] ?? []);
$sdkPath = dirname(__DIR__) . '/src';
$sdkEndpoints = scanSdkEndpoints($sdkPath);

// Group Postman endpoints by resource
$postmanByResource = groupByResource($postmanEndpoints);

// Create SDK endpoint lookup by endpoint name
$sdkByEndpoint = [];
foreach ($sdkEndpoints as $sdk) {
    $key = $sdk['endpoint'];
    if (!isset($sdkByEndpoint[$key])) {
        $sdkByEndpoint[$key] = [];
    }
    $sdkByEndpoint[$key][] = $sdk;
}

// Output
echo "=============================================================\n";
echo "  Lexoffice SDK Endpoint Coverage Report\n";
echo "=============================================================\n\n";

$totalPostman = count($postmanEndpoints);
$covered = 0;
$notCovered = [];

echo "API Endpoints from Postman Collection:\n";
echo "-------------------------------------------------------------\n";

foreach ($postmanByResource as $resource => $endpoints) {
    echo "\n📁 " . strtoupper($resource) . "\n";

    foreach ($endpoints as $endpoint) {
        $method = $endpoint['method'];
        $path = $endpoint['path'];
        $name = $endpoint['name'];
        $action = $endpoint['action'] ?? null;
        $hasFinalize = $endpoint['hasFinalize'] ?? false;

        // Check if this is covered by SDK
        $isCovered = false;
        $coverageNote = '';
        $normalizedPath = normalizePath($path);

        // Determine expected SDK method based on API endpoint
        $expectedActions = [];

        if ($action === 'render') {
            $expectedActions = ['render'];
        } elseif ($action === 'sendMail') {
            $expectedActions = ['sendMail'];
        } elseif ($action === 'pursue') {
            $expectedActions = ['pursue'];
        } elseif ($method === 'GET') {
            if (preg_match('#/[a-f0-9-]{36}$#', $path) || preg_match('#/\{id\}$#', $path)) {
                $expectedActions = ['get'];
            } else {
                $expectedActions = ['list', 'search', 'get'];
            }
        } elseif ($method === 'POST') {
            $expectedActions = ['create', 'upload'];
        } elseif ($method === 'PUT') {
            $expectedActions = ['update'];
        } elseif ($method === 'DELETE') {
            $expectedActions = ['delete'];
        }

        // Find matching SDK endpoint
        foreach ($sdkByEndpoint as $sdkEndpoint => $sdkMethods) {
            // Check if paths match (normalize both)
            if (strpos($normalizedPath, '/' . $sdkEndpoint) !== 0 && $normalizedPath !== '/' . $sdkEndpoint) {
                continue;
            }

            foreach ($sdkMethods as $sdkMethod) {
                if (in_array($sdkMethod['action'], $expectedActions)) {
                    $isCovered = true;

                    // Check finalize support
                    if ($hasFinalize && $sdkMethod['action'] === 'create') {
                        if (!$sdkMethod['hasCreateFinalize']) {
                            $coverageNote = ' (⚠️ finalize param missing)';
                            $isCovered = false;
                        }
                    }
                    break 2;
                }
            }
        }

        $status = $isCovered ? '✅' : '❌';
        if ($isCovered) {
            $covered++;
        } else {
            $notCovered[] = [
                'resource' => $resource,
                'method' => $method,
                'path' => $path,
                'name' => $name,
                'action' => $action,
                'hasFinalize' => $hasFinalize,
            ];
        }

        $actionInfo = $action ? " [$action]" : '';
        $finalizeInfo = $hasFinalize ? ' +finalize' : '';
        printf("   %s [%s] %-45s %s%s%s%s\n", $status, str_pad($method, 6), $path, $name, $actionInfo, $finalizeInfo, $coverageNote);
    }
}

// Summary
$percentage = $totalPostman > 0 ? round(($covered / $totalPostman) * 100, 1) : 0;

echo "\n=============================================================\n";
echo "  SUMMARY\n";
echo "=============================================================\n";
echo "Total API Endpoints in Postman:  $totalPostman\n";
echo "Covered by SDK:                  $covered\n";
echo "Not Covered:                     " . count($notCovered) . "\n";
echo "Coverage:                        $percentage%\n";

if (!empty($notCovered)) {
    echo "\n-------------------------------------------------------------\n";
    echo "  NOT COVERED ENDPOINTS (Potential SDK gaps)\n";
    echo "-------------------------------------------------------------\n";

    $byResource = [];
    foreach ($notCovered as $endpoint) {
        $byResource[$endpoint['resource']][] = $endpoint;
    }

    foreach ($byResource as $resource => $endpoints) {
        echo "\n📁 " . strtoupper($resource) . ":\n";
        foreach ($endpoints as $ep) {
            $actionInfo = isset($ep['action']) && $ep['action'] ? " [{$ep['action']}]" : '';
            $finalizeInfo = isset($ep['hasFinalize']) && $ep['hasFinalize'] ? ' +finalize' : '';
            printf("   ❌ [%s] %s - %s%s%s\n", $ep['method'], $ep['path'], $ep['name'], $actionInfo, $finalizeInfo);
        }
    }
}

// SDK Methods Report
echo "\n=============================================================\n";
echo "  SDK IMPLEMENTED METHODS\n";
echo "=============================================================\n";

$sdkByClass = [];
foreach ($sdkEndpoints as $sdk) {
    $sdkByClass[$sdk['class']][] = $sdk;
}
ksort($sdkByClass);

foreach ($sdkByClass as $class => $methods) {
    $hasFinalize = false;
    foreach ($methods as $m) {
        if ($m['action'] === 'create' && $m['hasCreateFinalize']) {
            $hasFinalize = true;
            break;
        }
    }
    $finalizeNote = $hasFinalize ? ' [create +finalize]' : '';
    echo "\n📦 $class:$finalizeNote\n";
    foreach ($methods as $m) {
        printf("   • %s() [%s] /%s\n", $m['method'], $m['httpMethod'], $m['endpoint']);
    }
}

echo "\n=============================================================\n";
echo "  Report generated: " . date('Y-m-d H:i:s') . "\n";
echo "=============================================================\n";

exit(count($notCovered) > 0 ? 1 : 0);
