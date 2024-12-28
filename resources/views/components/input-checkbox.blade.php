@props(['title', 'name', 'value', 'checked'])

<label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" class="sr-only peer" name="{{ $name }}" value="1" {{ $checked ? 'checked' : '' }}>
    <div class="relative w-12 h-6 bg-blue-200 rounded-full 
                peer peer-checked:after:translate-x-full 
                rtl:peer-checked:after:-translate-x-full 
                peer-checked:after:border-white after:content-[''] 
                after:absolute after:top-[2px] after:start-[2px] 
                after:bg-white after:border-gray-300 after:border 
                after:rounded-full after:h-5 
                after:w-5 after:transition-all  
                peer-checked:bg-blue-500">
    </div>
    <span class="ms-3 block font-medium text-sm text-gray-700 dark:text-gray-300">
          {{ $title ?? ''}}
      </span>
</label>