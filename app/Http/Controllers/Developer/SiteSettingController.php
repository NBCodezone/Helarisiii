<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SiteSettingController extends Controller
{
    /**
     * Show the maintenance mode settings page.
     */
    public function edit(): View
    {
        $setting = SiteSetting::current();

        return view('developer.site-settings', [
            'setting' => $setting,
            'statusOptions' => [
                SiteSetting::STATUS_LIVE => 'Live',
                SiteSetting::STATUS_MAINTENANCE => 'Maintenance',
            ],
        ]);
    }

    /**
     * Update the site maintenance status.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([SiteSetting::STATUS_LIVE, SiteSetting::STATUS_MAINTENANCE])],
            'maintenance_message' => ['nullable', 'string', 'max:500'],
        ]);

        $setting = SiteSetting::current();
        $setting->status = $data['status'];
        $setting->maintenance_message = $data['maintenance_message'] ?? null;
        $setting->maintenance_enabled_at = $data['status'] === SiteSetting::STATUS_MAINTENANCE
            ? now()
            : null;
        $setting->save();

        return redirect()
            ->route('developer.site-settings.edit')
            ->with('status', 'Site status updated successfully.');
    }
}
