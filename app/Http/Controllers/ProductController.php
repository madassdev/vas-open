<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AddBusinessProduct;
use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\RemoveProductForBusinessesRequest;
use App\Http\Requests\Product\UpdateBusinessProduct;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\BusinessProduct;
use App\Models\SubProduct;

class ProductController extends Controller
{
    //

    public function list()
    {
        $user = auth()->user();
        return $user;
    }

    public function listCategories()
    {
        $product_categories = ProductCategory::with('products')->get();
        return $this->sendSuccess("Product categories fetched successfully", ["product_categories" => $product_categories]);
    }

    public function getProductsConfiguration()
    {
        $business = auth()->user()->business;
        $products = $business->products
            ->map(function ($p) {
                return $p->createConfigDto()->only(
                    'name',
                    'shortname',
                    'category_name',
                    'unit_cost',
                    'description',
                    'logo',
                    'enabled',
                    'service_status',
                    'deployed',
                    'min_amount',
                    'max_amount',
                    'max_quantity',
                    'configurations',
                    'commission_type',
                    'has_fee',
                    'fee_configuration',
                    'type',
                    'created_at',
                    'updated_at',
                );
            });
        return $this->sendSuccess("Products configuration fetched successfully", [
            "products" => $products,
        ]);
    }

    public function getAllProducts()
    {
        $this->authorizeAdmin('list_products');
        $products = Product::paginate(10);
        return $this->sendSuccess("Products fetched successfully", [
            "products" => $products,
        ]);
    }

    public function getOneProduct(Product $product)
    {
        $this->authorizeAdmin('list_products');
        $product->load('productCategory');
        // businesses with this product and their configurations
        $businesses = DB::table('business_products')
            ->join('businesses', 'business_products.business_id', '=', 'businesses.id')
            ->where('business_products.product_id', $product->id)
            ->select(
                'businesses.name',
                'businesses.id',
                'businesses.logo',
                'business_products.commission_value'
            )
            ->paginate();
        foreach ($businesses as $business) {
            $business->commission_value = isset($business->commission_value) ? $business->commission_value : $product->provider_commission_value;
        }
        $product->load('subProducts');
        return $this->sendSuccess("Product fetched successfully", [
            "product" => $product,
            "businesses" => $businesses
        ]);
    }

    public function addProduct(AddProductRequest $request)
    {
        // if logo is present, save it to cloudinary
        $this->authorizeAdmin('edit_products');
        $logo = $request->logo;
        $all = $request->validated();
        if ($logo) {
            try {
                $upload = cloudinary()->upload($logo);
                $all['logo'] = $upload->getSecurePath();
            } catch (\Throwable $th) {
                return $this->sendError("Error uploading logo, pls ensure that the prefix data:image/{mime};base64, is part of the base64 image", [], 400);
            }
        }
        $product = Product::create($all);
        return $this->sendSuccess("Product added successfully", [
            "product" => $product,
        ]);
    }

    

    public function deleteProduct(Product $product)
    {
        $this->authorizeAdmin('edit_products');
        $product->delete();
        return $this->sendSuccess("Product deleted successfully", []);
    }

    public function updateProduct(UpdateProductRequest $request, Product $product)
    {
        // if logo is present, save it to cloudinary
        $this->authorizeAdmin('edit_products');
        $logo = $request->logo;
        $all = $request->validated();
        if ($logo) {
            try {
                $upload = cloudinary()->upload($logo);
                $all['logo'] = $upload->getSecurePath();
            } catch (\Throwable $th) {
                return $this->sendError("Error uploading logo, pls ensure that the prefix data:image/{mime};base64, is part of the base64 image", [], 400);
            }
        }
        $product->update($all);
        return $this->sendSuccess("Product updated successfully", [
            "product" => $product,
        ]);
    }

    public function getProductConfigurationForBusiness(Product $product, Business $business)
    {
        $businessProduct = $business->products()->where('product_id', $product->id)->first();
        if (!$businessProduct) {
            return $this->sendError("Business does not have this product", [], 404);
        }
        $configuration = $businessProduct->createConfigDto()->only(
            'name',
            'shortname',
            'category_name',
            'up_price',
            'description',
            'logo',
            'enabled',
            'service_status',
            'deployed',
            'min_amount',
            'max_amount',
            'max_quantity',
            'configurations',
            'commission_type',
            'has_fee',
            'fee_configuration',
            'type',
            'created_at',
            'updated_at',
        );
        $configuration['commission_value'] = $business->commission_value;
        return $this->sendSuccess("Product configuration fetched successfully", [
            "configuration" => $configuration,
        ]);
    }

    public function updateProductConfigurationForBusiness(UpdateBusinessProduct $request, Product $product, Business $business)
    {
        $this->authorizeAdmin('edit_products');
        $businessProduct = BusinessProduct::where('business_id', $business->id)->where('product_id', $product->id)->first();
        if (!$businessProduct) {
            return $this->sendError("Business does not have this product", [], 404);
        }
        // confirm that Product provider_commision is greater than or equal to the business commission
        if ($product->provider_commission_value < $request->commission_value) {
            return $this->sendError("Business commission cannot be greater than product provider commission", [], 400);
        }
        $businessProduct->update($request->all());
        return $this->sendSuccess("Product configuration updated successfully", [
            "configuration" => $businessProduct,
        ]);
    }

    public function deleteProductForBusiness(Product $product, Business $business)
    {
        $this->authorizeAdmin('edit_products');
        $businessProduct = BusinessProduct::where('business_id', $business->id)->where('product_id', $product->id)->first();
        if (!$businessProduct) {
            return $this->sendError("Business does not have this product", [], 404);
        }
        $businessProduct->delete();
        return $this->sendSuccess("Product deleted successfully", []);
    }

    public function addProductForBusiness(AddBusinessProduct $request, Product $product, Business $business)
    {
        $this->authorizeAdmin('edit_products');
        $businessProduct = BusinessProduct::where('business_id', $business->id)->where('product_id', $product->id)->first();
        if ($businessProduct) {
            return $this->sendError("Business already has this product", [], 400);
        }
        // confirm that Product provider_commision is greater than or equal to the business commission
        if ($product->provider_commission_value < $request->commission_value) {
            return $this->sendError("Business commission cannot be greater than product provider commission", [], 400);
        }
        $businessProduct = BusinessProduct::create([
            'business_id' => $business->id,
            'product_id' => $product->id,
            'commission_value' => $request->commission_value,
            'enabled' => $request->enabled,
        ]);
        return $this->sendSuccess("Product added successfully", [
            "configuration" => $businessProduct,
        ]);
    }

    public function addProductForBusinesses(AddBusinessProduct $request, Product $product)
    {
        $this->authorizeAdmin('edit_products');
        try {
            $businesses = Business::whereIn('id', $request->businesses)->get();
            BusinessProduct::upsert($businesses->map(function ($business) use ($product, $request) {
                return [
                    'business_id' => $business->id,
                    'product_id' => $product->id,
                    'commission_value' => $request->commission_value,
                    'enabled' => $request->enabled,
                ];
            })->toArray(), ['business_id', 'product_id'], ['commission_value', 'enabled']);
        } catch (\Throwable $th) {
            return $this->sendError("Error adding product to businesses" . " error: " . $th->getMessage(), [], 400);
        }

        return $this->sendSuccess("Product added successfully", [
            "configuration" => $businesses,
        ]);
    }

    public function removeProductForBusinesses(Product $product, RemoveProductForBusinessesRequest $request)
    {
        $this->authorizeAdmin('edit_products');
        BusinessProduct::whereIn('business_id', $request->businesses)->where('product_id', $product->id)->delete();
        return $this->sendSuccess("Product removed successfully from businesses", []);
    }
}
