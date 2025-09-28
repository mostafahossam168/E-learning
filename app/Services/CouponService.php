<?php

namespace App\Services;

use App\Models\Coupone;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponService
{
    use ApiResponse;
    /**
     * تحقق من الكوبون وتطبيقه
     */
    public  function applyCoupon(string $code, $course, $user)
    {
        $coupon = Coupone::where('code', $code)->first();

        if (!$coupon) {
            return $this->returnError('الكوبون غير موجود', 404);
        }

        if ($coupon->status->value !== 1) {
            return $this->returnError('الكوبون غير مفعل', 404);
        }

        $now = Carbon::now();
        if ($now->lt($coupon->start_date) || $now->gt($coupon->end_date)) {
            return $this->returnError('الكوبون منتهي أو لم يبدأ بعد', 404);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return $this->returnError('تم استخدام الكوبون الحد الأقصى', 404);
        }

        if ($coupon->course_id !== null && $coupon->course_id != $course->id) {
            return $this->returnError('الكوبون لا ينطبق على هذا الكورس', 404);
        }

        $discount = 0;
        if ($coupon->discount_type->value === 'percentage') {
            $discount = ($course->price * $coupon->discount_value) / 100;
        } elseif ($coupon->discount_type->value  === 'fixed') {
            $discount = $coupon->discount_value;
        }

        $finalPrice = max($course->price - $discount, 0);
        $data = [
            'coupone' => $coupon,
            'final_price' => $finalPrice,
        ];
        return $this->returnData($data, 'تم استخدام الكوبون بنجاح');
    }

    /**
     * تحديث عداد الاستخدام بعد الاشتراك
     */
    static public function markAsUsed(Coupone $coupon, $user): void
    {
        DB::transaction(function () use ($coupon, $user) {
            $coupon->increment('used_count');
            DB::table('coupon_usages')->insert([
                'coupone_id' => $coupon->id,
                'student_id'   => $user->id,
                'used_at'   => now(),
            ]);
        });
    }
}
