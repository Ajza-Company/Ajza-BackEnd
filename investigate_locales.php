<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Area;
use App\Models\AreaLocale;
use App\Models\Locale;

echo "=== LOCALE INVESTIGATION ===\n\n";

// 1. Check available locales
echo "1. Available locales:\n";
$locales = Locale::all();
foreach ($locales as $locale) {
    echo "- {$locale->locale} (default: " . ($locale->is_default ? 'yes' : 'no') . ")\n";
}

// 2. Check area counts
echo "\n2. Area counts:\n";
echo "- Total areas: " . Area::count() . "\n";
echo "- Total area locales: " . AreaLocale::count() . "\n";

// 3. Check area locales by language
echo "\n3. Area locales by language:\n";
$enCount = AreaLocale::whereHas('locale', function($q) { $q->where('locale', 'en'); })->count();
$arCount = AreaLocale::whereHas('locale', function($q) { $q->where('locale', 'ar'); })->count();
echo "- Areas with English: {$enCount}\n";
echo "- Areas with Arabic: {$arCount}\n";

// 4. Check specific examples
echo "\n4. Sample area locales:\n";
$sampleLocales = AreaLocale::with('locale')->take(5)->get();
foreach ($sampleLocales as $areaLocale) {
    echo "- Area {$areaLocale->area_id}: '{$areaLocale->name}' (locale: {$areaLocale->locale->locale})\n";
}

// 5. Test the HasLocalized trait behavior
echo "\n5. Testing HasLocalized trait:\n";
app()->setLocale('en');
echo "- App locale 'en': " . app()->getLocale() . "\n";
$areaEn = Area::with('localized')->first();
if ($areaEn && $areaEn->localized) {
    echo "- English result: {$areaEn->localized->name}\n";
} else {
    echo "- English result: No data found\n";
}

app()->setLocale('ar');
echo "- App locale 'ar': " . app()->getLocale() . "\n";
$areaAr = Area::with('localized')->first();
if ($areaAr && $areaAr->localized) {
    echo "- Arabic result: {$areaAr->localized->name}\n";
} else {
    echo "- Arabic result: No data found\n";
}

// 6. Check if there's a mismatch in the relationship
echo "\n6. Checking relationship mismatch:\n";
$area = Area::first();
if ($area) {
    echo "- Area ID: {$area->id}\n";
    
    // Check what the localized relationship returns
    $localized = $area->localized;
    if ($localized) {
        echo "- Localized name: {$localized->name}\n";
        echo "- Localized locale_id: {$localized->locale_id}\n";
        
        // Check what locale this actually is
        $actualLocale = Locale::find($localized->locale_id);
        if ($actualLocale) {
            echo "- Actual locale: {$actualLocale->locale}\n";
        }
    } else {
        echo "- No localized relationship found\n";
    }
}
