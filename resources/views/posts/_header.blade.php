<header class=" max-w-4xl mx-auto mt-20 text-center">
    <div class="max-w-xl mx-auto">
        <h1 class="text-4xl">
            Latest <span class="text-blue-500">Laravel From Scratch</span> News
        </h1>

        <div class="tw-flex tw-justify-center mt-4 space-y-2 lg:space-y-0 lg:space-x-4">
            <!-- Category -->
            <div class="relative lg:inline-flex bg-gray-100 rounded-xl">
                <x-category-dropdown/>
            </div>


            <!--Other Filters -->
            {{-- <span class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl ">
                <select name="" id=""
                    class="flex-1 appearance-none bg-transparent font-semibold pl-3 pr-9 py-2 text-sm">
                    <option value="" default selected>Other filters</option>
                    <option value="">foo</option>
                    <option value="">bar</option>
                </select>
                <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22"
                    height="22" viewBox="0 0 22 22">
                    <g fill="none" fill-rule="evenodd">
                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z">
                        </path>
                        <path fill="#222"
                            d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                    </g>
                </svg>
            </span> --}}


            <!-- Search -->
            <span class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl px-3 py-2 ">
                <form method="get" action="#">
                    <input type="text" name="search" placeholder="find something"
                        class="bg-transparent placeholder-black font-semibold text-sm"
                        value="{{request('search') ?? ''}}"
                        >
                </form>
            </span>

        </div>
    </div>
</header>
