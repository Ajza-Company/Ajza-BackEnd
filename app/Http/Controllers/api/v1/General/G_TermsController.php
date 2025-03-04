<?php

namespace App\Http\Controllers\api\v1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\Settings\A_UpdateTermsRequest;
use Illuminate\Http\Request;

class G_TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function terms()
    {
        if (file_exists(storage_path('app/settings/terms.txt'))) {
            $terms = file_get_contents(storage_path('app/settings/terms.txt'));
            return response()->json(['terms' => $terms]);
        }

        return response()->json(['error' => 'Terms not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateTerms(A_UpdateTermsRequest $request)
    {
        if (file_put_contents(storage_path('app/settings/terms.txt'), $request->terms)) {
            return response()->json(['message' => 'Terms updated successfully']);
        }

        return response()->json(['error' => 'Failed to update terms'], 500);
    }
}
