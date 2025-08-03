<?php

namespace App\Http\Controllers\api\v1\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class G_SettingsController extends Controller
{
    /**
     * Get all settings
     */
    public function index(): JsonResponse
    {
        try {
            $settings = Setting::getAll();
            
            return response()->json([
                'status' => true,
                'message' => 'تم استرجاع الإعدادات بنجاح',
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في استرجاع الإعدادات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific setting by key
     */
    public function show($key): JsonResponse
    {
        try {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) {
                return response()->json([
                    'status' => false,
                    'message' => 'الإعداد غير موجود'
                ], 404);
            }
            
            return response()->json([
                'status' => true,
                'message' => 'تم استرجاع الإعداد بنجاح',
                'data' => new SettingResource($setting)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في استرجاع الإعداد',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update or create a setting
     */
    public function store(SettingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $setting = Setting::setValue(
                $validatedData['key'], 
                $validatedData['value']
            );

            return response()->json([
                'status' => true,
                'message' => 'تم حفظ الإعداد بنجاح',
                'data' => new SettingResource($setting)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في حفظ الإعداد',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a specific setting
     */
    public function update(SettingRequest $request, $key): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $setting = Setting::setValue(
                $key, 
                $validatedData['value']
            );

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث الإعداد بنجاح',
                'data' => new SettingResource($setting)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في تحديث الإعداد',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a setting
     */
    public function destroy($key): JsonResponse
    {
        try {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) {
                return response()->json([
                    'status' => false,
                    'message' => 'الإعداد غير موجود'
                ], 404);
            }
            
            $setting->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'تم حذف الإعداد بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في حذف الإعداد',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get terms settings
     */
    public function getTerms(): JsonResponse
    {
        try {
            $termsKeys = ['rep_terms', 'client_terms', 'privacy_partner', 'privacy_client', 'company_terms'];
            $terms = Setting::getMultiple($termsKeys);
            
            return response()->json([
                'status' => true,
                'message' => 'تم استرجاع الشروط بنجاح',
                'data' => $terms
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في استرجاع الشروط',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order settings
     */
    public function getOrderSettings(): JsonResponse
    {
        try {
            $orderKeys = [
                'order_percentage',
                'rep_order_percentage', 
                'km_initial_cost_rep_order',
                'max_delivery_cost_rep_order',
                'delivery_initial_cost_rep_order'
            ];
            $orderSettings = Setting::getMultiple($orderKeys);
            
            // Convert to numeric values
            foreach ($orderSettings as $key => $value) {
                $orderSettings[$key] = is_numeric($value) ? (float)$value : 0;
            }
            
            return response()->json([
                'status' => true,
                'message' => 'تم استرجاع إعدادات الطلبات بنجاح',
                'data' => $orderSettings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في استرجاع إعدادات الطلبات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update multiple settings at once
     */
    public function updateMultiple(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'settings' => 'required|array',
                'settings.*.key' => 'required|string|max:255',
                'settings.*.value' => 'required|string'
            ]);

            $updatedSettings = [];
            foreach ($validatedData['settings'] as $settingData) {
                $setting = Setting::setValue(
                    $settingData['key'], 
                    $settingData['value']
                );
                $updatedSettings[] = $setting;
            }

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث الإعدادات بنجاح',
                'data' => SettingResource::collection($updatedSettings)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في تحديث الإعدادات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order settings
     */
    public function updateOrderSettings(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'order_percentage' => 'nullable|numeric|min:0|max:100',
                'rep_order_percentage' => 'nullable|numeric|min:0|max:100',
                'km_initial_cost_rep_order' => 'nullable|numeric|min:0',
                'max_delivery_cost_rep_order' => 'nullable|numeric|min:0',
                'delivery_initial_cost_rep_order' => 'nullable|numeric|min:0'
            ]);

            $updatedSettings = [];
            foreach ($validatedData as $key => $value) {
                if ($value !== null) {
                    $setting = Setting::setValue($key, (string)$value);
                    $updatedSettings[$key] = $value;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث إعدادات الطلبات بنجاح',
                'data' => $updatedSettings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'فشل في تحديث إعدادات الطلبات',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

}