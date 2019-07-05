<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AddPost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    private const MAX_HEIGHT = 300;

    /**
     * @var Filesystem
     */
    private $photoStorage;

    /**
     * PostController constructor.
     *
     * @param Filesystem $photoStorage
     */
    public function __construct(Filesystem $photoStorage)
    {
        $this->photoStorage = $photoStorage;
    }


    /**
     *  TODO: SPR issue
     *
     * @param $image
     *
     * @return \Intervention\Image\Image
     */
    private function prepareFile(UploadedFile $image): \Intervention\Image\Image
    {
        $img = Image::make($image);
        $img->resize(null, static::MAX_HEIGHT, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $img->encode();
    }

    /**
     * TODO: SPR issue
     *
     * @param $image
     *
     * @return string
     */
    private function getFileExtension(UploadedFile $image): string
    {
        return $image->getClientOriginalExtension();
    }

    /**
     * @param        $authorId
     * @param string $fileExtension
     *
     * @return string
     */
    private function generateFileName($authorId, string $fileExtension): string
    {
        return sprintf('%d_%d.%s', $authorId, time(), $fileExtension);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = Auth::guard()->user();

        return view('dashboard.index', [
            'posts' => Post::author($user->id)->paginate(3),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddPost $request
     *
     * @return RedirectResponse
     */
    public function add(AddPost $request): RedirectResponse
    {
        $author = Auth::guard()->user();

        $newFileName = $this->uploadFile($request->file('image'), $author);

        Post::create([
            'title' => $request->input('title'),
            'alt' => $request->input('alt'),
            'file_path' => $newFileName,
            'file_url' => $this->photoStorage->url($newFileName),
            'author_id' => $author->id,
        ]);

        return redirect()
            ->route('dashboard.index')
            ->with(['message' => __('Successfully Added')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     *
     * @return Factory|View
     */
    public function editForm(Post $post)
    {
        return view('dashboard.edit', [
            'post' => $post
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePost $request
     * @param Post       $post
     *
     * @return RedirectResponse
     */
    public function update(UpdatePost $request, Post $post): RedirectResponse
    {
        $post->fill([
            'title' => $request->input('title'),
            'alt' => $request->input('alt'),
        ]);

        if ($request->file('image')) {
            $author = Auth::guard()->user();

            $this->photoStorage->delete($post->file_path);

            $newFileName = $this->uploadFile($request->file('image'), $author);

            $post->file_path = $newFileName;
            $post->file_url = $this->photoStorage->url($newFileName);
        }

        $post->save();

        return redirect()
            ->route('dashboard.index')
            ->with(['message' => __('Successfully Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('dashboard.index')
            ->with(['message' => __('Successfully Deleted')]);
    }

    /**
     * @param UploadedFile $originalImage
     * @param              $author
     *
     * @return string
     */
    private function uploadFile(UploadedFile $originalImage, $author): string
    {
        $fileExtension = $this->getFileExtension($originalImage);
        $preparedfile = $this->prepareFile($originalImage);
        $newFileName = $this->generateFileName($author->id, $fileExtension);

        $this->photoStorage->put($newFileName, $preparedfile);

        return $newFileName;
    }

}
