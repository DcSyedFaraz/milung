<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'files' => 'array',
        'logocolor' => 'array',
        'packagingprinting' => 'array',
        'notice' => 'array',
        'capacity' => 'array',
        'labelFiles' => 'array',
        'logoFiles' => 'array',
        'manualFiles' => 'array',
        'safetySheetFiles' => 'array',
    ];

    public function getQuantityUnitAttribute($value)
    {
        // Extract numeric part from the quantity_sold attribute
        return (int) $value;
    }
    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'group');
    }
    public function orderSuppliers()
    {
        return $this->hasMany(OrderSupplier::class);
    }
    public function orderSuppliersOnly()
    {
        return $this->hasOne(OrderSupplier::class);
    }
    public function printview()
    {
        return $this->hasOne(Printview::class);
    }
    public function packinglist()
    {
        return $this->hasOne(PackingList::class);
    }
    public function buyerid()
    {
        return $this->belongsTo(BuyerProfile::class, 'buyer')->select('id', 'buyer_id');
    }
    public function supplierid()
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier','id')->select('id', 'supplier_id');
    }
    public function supplier()
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier');
    }
    public function shipmentOrders()
    {
        return $this->belongsTo(ShipmentOrder::class, 'so_number')->select('id', 'so_number');
    }
    public function information()
    {
        return $this->hasOne(Information::class, 'shipment_order_id', 'so_number')->select('id', 'invoice', 'shipment_order_id', 'created_at');
    }
    public function settleamount()
    {
        return $this->hasOne(SettleAmount::class, 'shipment_order_id', 'so_number');
    }
    public function shipmentSupplier()
    {
        return $this->hasOne(ShipmentSupplier::class, 'user_id', 'supplier');
    }
    public function invoice_number()
    {
        return $this->belongsToMany(SupplierInvoice::class)
            ->select('supplier_invoices.invoice_number','supplier_invoices.outstanding_amount');
    }
    public function invoices()
    {
        return $this->belongsToMany(SupplierInvoice::class);
    }
}
