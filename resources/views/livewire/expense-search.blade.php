<div class="flex items-center -mr-2">
    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative mytable">
        <thead>
            <tr class="sticky top-0 border-b border-gray-300 bg-gray-200 items-center text-sm">
                <th class="text-center">Date</th>
                <th class="py-4 text-left">Details</th>
                <th>Amount</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $day = 0;
                $bg = "bg-gray-100";
            ?>
            @forelse ($expenses as $expense)
                <?php
                    if( $day != \Carbon\Carbon::parse($expense->expense_date)->format('d') )
                        $bg = ($bg === "bg-gray-100")? "":"bg-gray-100";
                    
                    $day = \Carbon\Carbon::parse($expense->expense_date)->format('d')
                ?>
                <tr class="sticky top-0 {{ $bg }} border-b border-gray-300 items-center text-xs hover:bg-green-100" data-amount="{{$expense->amount}}">
                    <td class="w-12 text-center py-2">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }} </td>
                    <td>{{ $expense->description }}</td>
                    <td class="w-16 px-1 text-right text-teal-800 font-bold">@money( $expense->amount )</td>
                    <td class="w-12">
                        <a href="{{route('expense.edit', ['expense'=>$expense->id])}}" class="flex-shrink-0 boder text-gray-600 py-2 px-3 focus:outline-none active:text-gray-800 active:shadow-inner hover:text-gray-700">
                            <i class="fas fa-edit"></i>
                        </a>                            
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="4">Nothing to show</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="absolute bottom-0 w-full bg-teal-800 text-white py-2 text-right pr-4">
    Total : <span class="total_amount">@money( $expenses->sum('amount') )</span>
</div>
