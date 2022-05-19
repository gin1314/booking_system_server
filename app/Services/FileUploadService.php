<?php


namespace App\Services;

use App\Models\Bol;
use App\Models\Booking;
use App\Models\DockReceipt;
use App\Models\File;
use App\Models\FileUpload;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class FileUploadService
{
    // /**
    //  *
    //  * @var FileRepository
    //  */
    // protected $fileRepository;

    // public function __construct(FileRepository $fileRepository)
    // {
    //      $this->repo = $fileRepository;
    // }

    // public function findFilesByDockReceipt(DockReceipt $dockReceipt)
    // {
    //     return $this->repo->findFilesByDockReceipt($dockReceipt);
    // }

    // public function findFilesByBol(Bol $bol)
    // {
    //     return $bol->files()->get();
    // }

    public function addBookingFile(Booking $booking, Request $request)
    {
        // @TODO: replace name as the actual path
        $files = [];
        if ($request->hasFile('file')) {

            // $filess = $request->file('file');
            foreach ($request->file('file') as $uploadedFile) {
                $file = new FileUpload;
                $file->hash = sha1_file($uploadedFile->getPathname());
                $file->file_name = $uploadedFile->getClientOriginalName();
                $file->code = substr(sha1(rand()), 0, 6);
                // zero for now
                $file->uploaded_by = 0;
                $file->type = $request->get('type');
                $file->uploadable_type = Booking::class;
                $file->uploadable_id = $booking->id;
                $file->type = $request->get('type');
                $extension = strtolower($uploadedFile->getClientOriginalExtension());
                $file->file_extension = $extension;


                $file->save();
                $files[] = $file;
                $uploadedFile->storeAs("uploads/booking/{$booking->id}", "{$file->hash}.{$extension}");
            }

            // $file = new FileUpload;
            // $file->hash = sha1_file($request->file('file')->getPathname());
            // $file->file_name = $request->file('file')->getClientOriginalName();
            // $file->code = substr(sha1(rand()), 0, 6);
            // $file->uploaded_by = auth()->user()->id;
            // $file->type = $request->get('type');
            // $file->uploadable_type = Booking::class;
            // $file->uploadable_id = $booking->id;
            // $file->type = $request->get('type');
            // $extension = strtolower($request->file('file')->extension());
            // $file->file_extension = $extension;


            // $file->save();

            // $request->file->storeAs("uploads/booking/{$booking->id}", "{$file->hash}.{$extension}");
            return collect($files);
        }

        return $request;
    }

    public function addAvatarFile(User $user, Request $request)
    {
        // @TODO: replace name as the actual path
        if ($request->hasFile('file')) {
            $file = new FileUpload;
            $file->hash = sha1_file($request->file('file')->getPathname());
            $file->name = $request->file('file')->getClientOriginalName();
            $file->code = substr(sha1(rand()), 0, 6);
            $file->createdAt = date('Y-m-d H:i:s');
            $file->uploadedby = auth()->user()->id;
            $file->uploadable_type = User::class;
            $file->uploadable_id = $user->id;

            $file->type = 'profile_image';
            $extension = strtolower($request->file('file')->extension());
            $file->save();
            $request->file->storeAs("uploads/users/images/{$user->id}", "{$file->hash}.{$extension}");
            return $file;
        }

        return $request;
    }

    // public function addBolFile(Bol $bol, Request $request)
    // {
    //     // @TODO: replace name as the actual path
    //     if ($request->hasFile('file')) {
    //         $file = new File;
    //         $file->hash = sha1_file($request->file('file')->getPathname());
    //         $file->name = $request->file('file')->getClientOriginalName();
    //         $file->code = substr(sha1(rand()), 0, 6);
    //         $file->createdAt = date('Y-m-d H:i:s');
    //         $file->uploadedby = auth()->user()->id;
    //         $file->uploadable_type = Bol::class;
    //         $file->uploadable_id = $bol->id;

    //         $file->type = $request->get('type');
    //         $extension = strtolower($request->file('file')->extension());
    //         $file->save();
    //         $request->file->storeAs("uploads/bol/{$bol->id}", "{$file->hash}.{$extension}");
    //         return $file;
    //     }

    //     return $request;
    // }

    // public function deleteFile(File $file)
    // {
    //     File::where('id', $file->id)->delete();
    //     return $file;
    // }
}