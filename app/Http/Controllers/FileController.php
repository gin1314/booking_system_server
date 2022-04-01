<?php

namespace App\Http\Controllers;

use App\Models\Bol;
use App\Models\Booking;
use App\Models\DockReceipt;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use App\Services\FileUploadService;
use App\Transformers\FileTransformer;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     *
     * @var FileUploadService
     */
    protected $FileService;

    public function __construct(FileUploadService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function findFilesByDockReceipt(Booking $booking)
    {
        $files = $this->fileService->findFilesByDockReceipt($booking);

        return fractal($files, new FileTransformer)->respond();
    }

    // public function findFilesByBol(Bol $bol)
    // {
    //     $files = $this->fileService->findFilesByBol($bol);

    //     return fractal($files, new FileTransformer)->respond();
    // }

    public function addBookingFile(Booking $booking, Request $request)
    {
        $files = $this->fileService->addBookingFile($booking, $request);
        return fractal($files, new FileTransformer)->respond();
    }

    public function addAvatarFile(User $user, Request $request)
    {
        $files = $this->fileService->addAvatarFile($user, $request);
        return fractal($files, new FileTransformer)->respond();
    }

    public function addBolFile(Bol $bol, Request $request)
    {
        $files = $this->fileService->addBolFile($bol, $request);
        return fractal($files, new FileTransformer)->respond();
    }

    public function deleteFile(File $file)
    {
        $files = $this->fileService->deleteFile($file);
        return fractal($files, new FileTransformer)->respond();
    }
}
