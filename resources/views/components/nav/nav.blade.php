<div class="d-flex bg-dark flex-wrap align-items-center justify-content-center justify-content-lg-start py-2"> <a
        href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none"> <svg
            class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
            <use xlink:href="#bootstrap"></use>
        </svg> </a>
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="{{ route('new-sale') }}" class="nav-link px-2 link-secondary">Nova Venda</a></li>
        <li><a href="{{ route('client.index') }}" class="nav-link px-2 link-secondary">Clientes</a></li>
        <li><a href="{{ route('product.index') }}" class="nav-link px-2 link-secondary">Produtos</a></li>
        <li><a href="{{ route('sales.index') }}" class="nav-link px-2 link-secondary">Vendas</a></li>
    </ul>
    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search"> <input type="search" class="form-control"
            placeholder="Search..." aria-label="Search"> </form>

</div>