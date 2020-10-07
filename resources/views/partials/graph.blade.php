<div class="flex justify-between items-center px-3 py-3 ">
    <h1 class="font-sans font-bold subpixel-antialiased text-base text-gray-700 ">
        Expenses
    </h1>         
</div>
<div class="bg-white border rounded m-1 shadow relative">
    <div class="hide flex absolute w-full h-full bg-gray-800 bg-opacity-25">
        <div class="lds-ripple m-auto">
            <div></div>
            <div></div>
        </div>                
    </div>


    <div class="flex justify-between px-3 py-4 items-center">
        <div class="flex items-center">
            <div class="border rounded text-sm py-1 px-2 mr-2">
                <select name="" id="" class="chart_periode">
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="border rounded text-sm py-1 px-2">
                <select name="" id="" class="chart_type">
                    <option value="line">Line</option>
                    <option value="bar">Bar</option>
                </select>
            </div>
        </div>
        <div class="flex">
            <button class="border bg-gray-100 px-3 py-2 mx-1 hover:bg-gray-200 active:bg-gray-300 chart_change" data-direction="prev" data-value="0"><i class="fas fa-angle-left"></i></button>
            <button class="border bg-gray-100 px-3 py-2 mx-1 hover:bg-gray-200 active:bg-gray-300 chart_change" data-direction="next" data-value="0"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

    <div class="min-h-30">
        <canvas id="myChart" width="100%"></canvas>
    </div>

</div>