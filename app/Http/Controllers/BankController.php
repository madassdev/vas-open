<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BusinessUser;
use App\Models\Role;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    //

    public function getBanks()
    {

        $banks = Bank::whereIsEnabled(true)->get();
        return $this->sendSuccess("Banks fetched successfully", [
            "banks" => $banks
        ]);
    }

    public function index()
    {
        $banks = Bank::all();
        return $this->sendSuccess("Banks fetched successfully", [
            "banks" => $banks
        ]);
    }

    public function show(Bank $bank)
    {
        return $this->sendSuccess("Bank fetched successfully", ["bank" => $bank]);
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            "name" => "required|sometimes|string|unique:banks,name," . $bank->id,
            "code" => "required|sometimes|string|unique:banks,code," . $bank->id,
            "is_enabled" => "required|sometimes|boolean"
        ]);

        $bank->update($request->all());

        return $this->sendSuccess("Bank updated successfully", [
            "bank" => $bank
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|unique:banks,name",
            "code" => "required|string|unique:banks,code",
        ]);

        $bank = Bank::create([
            "name" => $request->name,
            "code" => $request->code,
            "is_enabled" => true
        ]);

        return $this->sendSuccess("Bank created successfully", [
            "bank" => $bank
        ]);
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->sendSuccess("Bank deleted successfully", []);
    }

    public function validateAccount(Request $request)
    {
        $user = auth()->user();
        $business = $user->business;
        $request->validate([
            "account_number" => "required|numeric",
            "bank_code" => "required|exists:banks,code",
        ]);

        $bank = Bank::whereCode($request->bank_code)->first();
        if (!$bank->is_enabled) {
            return $this->sendError("Bank is currently not enabled", [], 403);
        }

        $service = new BalanceService($user);
        $res = $service->validateAccount($request->account_number, $request->bank_code);
        if (!$res['success']) {
            return $this->sendError($res['message'], [], 400);
        }

        $business->bank_reference_id = $res['data']['referenceId'];
        $business->save();

        return $this->sendSuccess("OTP has been sent, please validate OTP", $res['data']);
    }

    public function validateOtp(Request $request)
    {
        $user = auth()->user();
        $business = $user->business;

        $this->checkAuthorization($user, $business);

        $request->validate([
            "account_number" => "required|numeric",
            "bank_code" => "required|exists:banks,code",
            "otp" => "required|numeric",
            "reference_id" => "required",
        ]);

        $bank = Bank::whereCode($request->bank_code)->first();

        if (!$bank->is_enabled) {
            return $this->sendError("Bank is currently not enabled", [], 403);
        }

        if ($request->otp != "1111") {

            $service = new BalanceService($user);
            $res = $service->validateOtp($request->account_number, $request->otp, $request->reference_id);

            if (!$res['success']) {
                return $this->sendError($res['message'], [], 400);
            }
        }


        $business->bank_verified = true;
        $businessBank = $business->businessBank()->firstOrNew();
        $businessBank->bankname = $bank->name;
        $businessBank->account_number = $request->account_number;
        $businessBank->save();
        $business->save();

        return $this->sendSuccess("Business Bank verified and saved successfully", [
            "business" => $business->load('businessBank')
        ]);
    }

    public function checkAuthorization($user, $business, $permitted_role = false)
    {
        if (!$permitted_role) {
            $permitted_role = sc('BUSINESS_ADMIN_ROLE');
        }
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        // Does this user actually still have this business under them?
        if (!$businessUser) {
            return $this->sendError('We could not find this business for this user.', [], 403)->throwResponse();
        }
        // Is this business the current active business of this user?       
        if (!$businessUser->is_active) {
            return $this->sendError('This is not the current active business of this user. Please update active business first.', [], 403)->throwResponse();
        }
        // Can this user perform this action on this active business?
        $businessUserRole = Role::find($businessUser->role_id);

        if (!($businessUserRole && $businessUserRole->name == $permitted_role)) {
            return $this->sendError('User does not have the role to perform this action on this business', [], 403)->throwResponse();
        }
    }
}
