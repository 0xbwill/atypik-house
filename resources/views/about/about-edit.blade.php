<x-app-layout>
    <div class="container mx-auto py-8 px-4 max-w-4xl">
        <h1 class="mt-2 text-5xl font-bold text-bleu">Edit About Page</h1>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h2 class="mt-2 text-3xl font-semibold text-bleu">Section 1</h2>
                <div class="border-t border-gray-300 mt-4 pt-4">
                    <div class="mb-4">
                        <label for="section1_title" class="block text-gray-700 font-medium">Section 1 Title</label>
                        <input type="text" name="section1_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section1_title }}">
                    </div>
                    <div class="mb-4">
                        <label for="section1_subtitle" class="block text-gray-700 font-medium">Section 1 Subtitle</label>
                        <input type="text" name="section1_subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section1_subtitle }}">
                    </div>
                    <div class="mb-4">
                        <label for="section1_description" class="block text-gray-700 font-medium">Section 1 Description</label>
                        <textarea name="section1_description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $about->section1_description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="section1_button_text" class="block text-gray-700 font-medium">Section 1 Button Text</label>
                        <input type="text" name="section1_button_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section1_button_text }}">
                    </div>
                    <div class="mb-4">
                        <label for="section1_button_link" class="block text-gray-700 font-medium">Section 1 Button Link</label>
                        <input type="text" name="section1_button_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section1_button_link }}">
                    </div>
                    <div class="mb-4">
                        <label for="section1_image" class="block text-gray-700 font-medium">Section 1 Image</label>
                        <input type="file" name="section1_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h2 class="mt-2 text-3xl font-semibold text-bleu">Section 2</h2>
                <div class="border-t border-gray-300 mt-4 pt-4">
                    <div class="mb-4">
                        <label for="section2_title" class="block text-gray-700 font-medium">Section 2 Title</label>
                        <input type="text" name="section2_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section2_title }}">
                    </div>
                    <div class="mb-4">
                        <label for="section2_subtitle" class="block text-gray-700 font-medium">Section 2 Subtitle</label>
                        <input type="text" name="section2_subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section2_subtitle }}">
                    </div>
                    <div class="mb-4">
                        <label for="section2_description" class="block text-gray-700 font-medium">Section 2 Description</label>
                        <textarea name="section2_description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $about->section2_description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="section2_button_text" class="block text-gray-700 font-medium">Section 2 Button Text</label>
                        <input type="text" name="section2_button_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section2_button_text }}">
                    </div>
                    <div class="mb-4">
                        <label for="section2_button_link" class="block text-gray-700 font-medium">Section 2 Button Link</label>
                        <input type="text" name="section2_button_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $about->section2_button_link }}">
                    </div>
                    <div class="mb-4">
                        <label for="section2_image" class="block text-gray-700 font-medium">Section 2 Image</label>
                        <input type="file" name="section2_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>

            <button type="submit" class="bg-vert text-white px-4 py-2 rounded-md hover:bg-green-700" role="button" aria-label="sauvegarder">Sauvegarder</button>
        </form>
    </div>
</x-app-layout>
