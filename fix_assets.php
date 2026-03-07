<?php
// fix_assets.php

function fixAssets($filePath) {
    if (!file_exists($filePath)) {
        echo "File not found: $filePath\n";
        return;
    }

    $content = file_get_contents($filePath);

    // Replace href="asset/..." with href="{{ asset('asset/...') }}"
    $content = preg_replace('/href="asset\/([^"]+)"/', 'href="{{ asset(\'asset/$1\') }}"', $content);

    // Replace src="asset/..." with src="{{ asset('asset/...') }}"
    $content = preg_replace('/src="asset\/([^"]+)"/', 'src="{{ asset(\'asset/$1\') }}"', $content);

    file_put_contents($filePath, $content);
    echo "Fixed assets in $filePath\n";
}

fixAssets('resources/views/layouts/header.blade.php');
fixAssets('resources/views/layouts/footer.blade.php');
