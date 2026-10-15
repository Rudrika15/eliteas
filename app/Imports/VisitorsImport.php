<?php

namespace App\Imports;

use App\Models\VisitorsDetails;
use App\Models\BusinessCategory;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VisitorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            if (collect($row)->filter(function ($value) {
                return trim($value) !== '';
            })->isEmpty()) {
                return null;
            }

            $name = trim($row['name'] ?? '');
            // dd($name);
            $parts = explode(' ', $name, 2);
            $firstName = $parts[0] ?? null;
            $lastName  = $parts[1] ?? null;

            $mobile = $row['mobile_number'] ?? null;
            $email  = $row['email_id'] ?? null;
            $city   = $city = trim($row['city']);

            if (empty($mobile) && empty($email)) return null;

            // Business category
            $categoryId = null;
            if (!empty($row['business_category'])) {
                $categoryName = trim($row['business_category']);
                $categoryId = BusinessCategory::whereRaw(
                    'LOWER(categoryName) = ?',
                    [strtolower($categoryName)]
                )->value('id');

                if (!$categoryId) {
                    $category = BusinessCategory::create([
                        'categoryName' => $categoryName,
                        'status' => 'Active'
                    ]);
                    $categoryId = $category->id;
                }
            }

            // Invited by
            $invitedBy = null;
            if (!empty($row['reference_by'])) {
                $refName = trim($row['reference_by']);

                $member = Member::whereRaw(
                    "LOWER(CONCAT_WS(' ', firstName, lastName)) = ?",
                    [strtolower($refName)]
                )->first();

                if ($member) {
                    // ✅ Store member ID as string
                    $invitedBy = (string) $member->id;
                } else {
                    // ✅ Store direct text
                    $invitedBy = $refName;
                }
            }

            // Existing visitor check
            $visitor = VisitorsDetails::where(function ($q) use ($mobile, $email) {
                if ($mobile) $q->where('mobileNo', $mobile);
                if ($email) $q->orWhere('email', $email);
            })->first();

            if ($visitor) {
                $visitor->update([
                    'firstName' => $firstName,
                    'lastName'  => $lastName,
                    'email'     => $email,
                    'mobileNo'  => $mobile,
                    'businessName' => $row['company_name'] ?? null,
                    'businessCategory' => $categoryId,
                    'city' => $city,
                    'invitedBy' => $invitedBy,
                    'status'    => 'Active',
                ]);
                return $visitor;
            }

            return new VisitorsDetails([
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'email'     => $email,
                'mobileNo'  => $mobile,
                'businessName' => $row['company_name'] ?? null,
                'businessCategory' => $categoryId,
                'city' => $city,
                'invitedBy' => $invitedBy,
                'status'    => 'Active',
                'createdBy' => Auth::id(),
                'isUser'    => 'No',
            ]);
        } catch (\Exception $e) {
            \Log::error('Visitor Import Error', [
                'message' => $e->getMessage(),
                'row' => $row
            ]);
        }
    }
}
