<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'hash',
    //     'name',
    //     'code',
    //     'createdAt',
    //     'uploadedby',
    //     'dr_id',
    // ];

    // public $timestamps = false;

    protected $table = 'file_uploads';

    // protected $with = ['uploadedBy'];

    protected $appends = ['uploaded_file_name', 'file_extension'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function getUploadedFileNameAttribute()
    {
        $ext = pathinfo($this->attributes['file_name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext ? ".{$ext}" : '');
        return $this->attributes['hash'] . $ext;
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->attributes['file_name'], PATHINFO_EXTENSION);
    }

    public function uploadable()
    {
        return $this->morphTo();
    }
}
