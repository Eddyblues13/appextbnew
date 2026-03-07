<?php
// fix_more_assets.php

function fixAssets($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $content = file_get_contents($filePath);

    // Replace href="asset/..." with href="{{ asset('asset/...') }}"
    $content = preg_replace('/href="asset\/([^"{}]+)"/', 'href="{{ asset(\'asset/$1\') }}"', $content);

    // Replace src="asset/..." with src="{{ asset('asset/...') }}"
    $content = preg_replace('/src="asset\/([^"{}]+)"/', 'src="{{ asset(\'asset/$1\') }}"', $content);

    // Replace href="uploads/..." with href="{{ asset('uploads/...') }}"
    $content = preg_replace('/href="uploads\/([^"{}]+)"/', 'href="{{ asset(\'uploads/$1\') }}"', $content);

    // Replace src="uploads/..." with src="{{ asset('uploads/...') }}"
    $content = preg_replace('/src="uploads\/([^"{}]+)"/', 'src="{{ asset(\'uploads/$1\') }}"', $content);

    file_put_contents($filePath, $content);
    echo "Fixed assets in $filePath\n";
}

fixAssets('resources/views/user/header.blade.php');
fixAssets('resources/views/user/footer.blade.php');
fixAssets('resources/views/admin/header.blade.php');
fixAssets('resources/views/admin/footer.blade.php');
fixAssets('resources/views/layouts/header.blade.php');
fixAssets('resources/views/layouts/footer.blade.php');
