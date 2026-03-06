<?php
$dir = __DIR__ . '/resources/views/user';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($files as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        $original = $content;

        // 1. Replace explicit $ before {{ number_format
        $content = preg_replace('/\$(\s*)\{\{\s*number_format\(/', '{{ Auth::user()->currency }}$1{{ number_format(', $content);

        // 2. Add currency before {{ number_format for standard balances if missing
        $content = preg_replace('/([> \t\n]+)\{\{\s*number_format\(\$(savings_balance|checking_balance|totalSavingsCredit|totalSavingsDebit|totalCheckingCredit|totalCheckingDebit|amount)/', '$1{{ Auth::user()->currency }}{{ number_format($$2', $content);

        // 3. Prevent duplicate currencies
        $content = str_replace('{{ Auth::user()->currency }}{{ Auth::user()->currency }}', '{{ Auth::user()->currency }}', $content);
        $content = str_replace('{{ Auth::user()->currency }} {{ Auth::user()->currency }}', '{{ Auth::user()->currency }}', $content);
        $content = str_replace('${{ Auth::user()->currency }}', '{{ Auth::user()->currency }}', $content);

        if ($content !== $original) {
            file_put_contents($file->getRealPath(), $content);
            echo "Updated " . $file->getFilename() . "\n";
        }
    }
}
echo "Done.\n";
