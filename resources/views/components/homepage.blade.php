<div class="row mt-5 d-flex justify-content-start align-items-center">
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#f44336',
            'color' => 'white',
            'iconClass' => 'fas fa-dollar-sign',
            'title' => 'Total Gross Profit',
            'content' => 'BDT ' . $total_gross_profit,
        ])
    </div>
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#81c784',
            'color' => 'white',
            'iconClass' => 'fas fa-shopping-cart',
            'title' => 'Total Number of Orders',
            'content' => $total_orders,
        ])
    </div>
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#84c7c7',
            'color' => 'white',
            'iconClass' => 'fas fa-dollar-sign',
            'title' => 'Total Sales',
            'content' => 'BDT ' . $total_sales,
        ])
    </div>
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#4CAF50',
            'color' => 'white',
            'iconClass' => 'fas fa-shopping-cart',
            'title' => 'Total Products Sold',
            'content' => $total_products_sold,
        ])
    </div>
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#f4b336',
            'color' => 'white',
            'iconClass' => 'fas fa-archive',
            'title' => 'Total Products in Stock',
            'content' => $products_in_stock,
        ])
    </div>
    <div class="col-md-4 mb-4">
        @include('components.card', [
            'backgroundColor' => '#8481c7',
            'color' => 'white',
            'iconClass' => 'fas fa-cubes',
            'title' => 'Varieties of Products',
            'content' => $number_of_products,
        ])
    </div>
</div>
</div>
