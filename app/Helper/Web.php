<?php

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

function slugCreate($modelName, $slug_text, $slugColumn = 'slug')
{
    $slug = Str::slug($slug_text, '-');
    $i = 1;
    while ($modelName::where($slugColumn, $slug)->exists()) {
        $slug = Str::slug($slug_text, '-') . '-' . $i++;
    }
    return $slug;
}

function slugUpdate($modelName, $slug_text, $modelId, $slugColumn = 'slug')
{
    $slug = Str::slug($slug_text, '-');
    $i = 1;
    while ($modelName::where($slugColumn, $slug)->where('id', '!=', $modelId)->exists()) {
        $slug = Str::slug($slug_text, '-') . '-' . $i++;
    }
    return $slug;
}

// function fileUpload($file, $path)
// {
//     $fileName = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
//     $filePath = $path . '/' . $fileName;

//     // Handle image files
//     if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
//         // Resize image
//         Image::make($file)->resize(400, 400, function ($constraint) {
//             $constraint->aspectRatio();
//         })->save(public_path($filePath));
//     } else {
//         // Handle other file types (e.g., pdf, doc, docx)
//         $file->move(public_path($path), $fileName);
//     }

//     return $filePath;
// }
function fileUpload($file, $path, $width = 400, $height = 400)
{
    $image_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
    $imagePath = $path . '/' . $image_name;
    Image::make($file)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path($imagePath));

    return $imagePath;
}

function orderId()
{
    $timestamp = now()->format('YmdHis');
    $randomString = Str::random(6);
    return $timestamp . $randomString;
}

function responsejson($message, $data = "success")
{
    return response()->json(
        [
            'data' => $data,
            'message' => $message
        ]
    );
}

function pdforelse($file, $path, $width = 400, $height = 400)
{
    $extension = $file->getClientOriginalExtension();

    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
        $image_name = uniqid() . '-' . time() . '.webp';
        $imagePath = $path . '/' . $image_name;
        // Process the image
        Image::make($file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path($imagePath));

        return $imagePath;
    } elseif ($extension === 'pdf') {
        // Generate a unique name for the PDF file
        $pdf_name = uniqid() . '-' . time() . '.' . $extension;
        $pdfPath = $path . '/' . $pdf_name;
        // Store the PDF file without image processing
        $file->move(public_path($path), $pdf_name);

        return $pdfPath;
    } else {
        // Handle unsupported file types
        throw new \Exception("Unsupported file type: " . $extension);
    }
}

function upload_image($filename, $path, $width = 400, $height = 400)
{
    $imagename = uniqid() . '.' . $filename->getClientOriginalExtension();
    $new_webp = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $imagename);

    Image::make($filename)->encode('webp', 90)->fit($width, $height)->save($path . $new_webp);
    $image_upload = $path . $new_webp;
    return $image_upload;
}

function Upload($file, $path, $width = 400, $height = 400)
{
    $image_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
    $new_webp = pathinfo($image_name, PATHINFO_FILENAME) . '.webp';
    $imagePath = $path . '/' . $new_webp;

    Image::make($file)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path($imagePath));

    return $imagePath;
}

function handleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
{
    $name = time() . $file->getClientOriginalName();

    $file->move(base_path('public/') . $path, $name);
    if ($data[$field] != null) {
        if (file_exists(base_path('public/') . $delete_path . $data[$field])) {
            unlink(base_path('public/') . $delete_path . $data[$field]);
        }
    }
    return $name;
}

if (!function_exists('uploadany_file')) {
    function uploadany_file($filename, $path = 'uploads/licence-holders/')
    {
        $uploadPath = $path;
        $i = 1;

        $extension = $filename->getClientOriginalExtension();
        $name =  uniqid() . $i++ . '.' . $extension;
        $filename->move($uploadPath, $name);

        return $uploadPath . $name;
    }
}

function convertfloat($originalNumber)
{
    return str_replace(',', '', $originalNumber);
}


