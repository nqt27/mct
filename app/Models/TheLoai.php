<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Output\Theme;

class TheLoai extends Model
{
    // Khai báo bảng tương ứng với model (nếu khác với tên model theo chuẩn Laravel)
    protected $table = 'theloai';

    // Khai báo các cột có thể thao tác (mass assignable)
    protected $fillable = ['ten', 'parent_id', 'slug', 'position', 'is_active'];

    /**
     * Quan hệ đệ quy để lấy menu con (submenus)
     */
    
    public function audio()
    {
        return $this->hasMany(Audio::class);
    }
    public function submenu()
    {
        return $this->hasMany(Theloai::class, 'parent_id');
    }

    /**
     * Quan hệ để lấy menu cha
     */
    public function parentMenu()
    {
        return $this->belongsTo(TheLoai::class, 'parent_id');
    }

    /**
     * Phạm vi truy vấn các menu cha (cấp 1)
     */
    public function scopeParentMenus($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Phạm vi truy vấn các menu con của một menu cụ thể
     */
    public function scopeSubMenusOf($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }
}
