<?php

uses()->group('app');

it('The codebase must not use potentially dangerous functions to ensure code security.', function ($fns) {
    expect($fns)->not->toBeUsed();
})->with([
    'eval',
    'dd',
    'dump',
    'var_dump',
    'exec',
    'system',
    'passthru',
    'popen',
    'shell_exec',
    'passthru',
    'proc_open',
    'popen',
    'curl_exec',
    'curl_multi_exec',
    'parse_str',
    'mb_ereg_replace',
    'preg_replace_callback',
    'create_function',
    'include',
    'include_once',
    'require',
    'require_once',
    'unserialize',
    'pcntl_exec',
    'file_get_contents',
    'file_put_contents',
    'fopen',
    'fwrite',
    'fread',
    'unlink'
]);



