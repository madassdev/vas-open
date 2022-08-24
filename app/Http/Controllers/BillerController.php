<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use Illuminate\Http\Request;

class BillerController extends Controller
{
    //
    public function index()
    {
        $billers = Biller::all();

        return $this->sendSuccess("Billers fetched successfully", [
            "billers" => $billers
        ]);
    }

    public function show(Biller $biller)
    {
        return $this->sendSuccess("Biller fetched successfully", ["biller" => $biller]);
    }

    public function update(Request $request, Biller $biller)
    {
        $request->validate([
            "name" => "required|sometimes|string",
            "shortname" => "required|sometimes|string|unique:billers,shortname," . $biller->id,
            "vendor_code" => "required|sometimes|unique:billers,vendor_code," . $biller->id,
            "is_enabled" => "required|sometimes|boolean"
        ]);

        $biller->update($request->all());

        return $this->sendSuccess("Biller updated successfully", [
            "biller" => $biller
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "shortname" => "required|string|unique:billers,shortname",
            "vendor_code" => "required|unique:billers,vendor_code",
            "is_enabled" => "required|sometimes|boolean"
        ]);

        $biller = Biller::create([
            "name" => $request->name,
            "shortname" => $request->shortname,
            "vendor_code" => $request->vendor_code,
        ]);

        return $this->sendSuccess("Biller created successfully", [
            "biller" => $biller
        ]);
    }

    public function destroy(Biller $biller)
    {
        $biller->delete();
        return $this->sendSuccess("Biller deleted successfully", []);
    }
}
