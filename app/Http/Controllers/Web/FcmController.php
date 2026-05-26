<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdminDeviceToken;
use Illuminate\Http\Request;

class FcmController extends Controller
{
    public function storeToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $admin = auth('admin')->user();
        AdminDeviceToken::updateOrCreate(
            ['token' => $request->token],
            ['admin_id' => $admin->id]
        );

        return response()->json(['status' => 'stored']);
    }
}
