<div class="d-flex bg-dark flex-wrap align-items-center justify-content-center justify-content-lg-start py-2">
    <a href="{{route('new-sale')}}"
        class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img src="{{ asset('img/logo.png') }}" alt="logo" width="100" height="32">
    </a>
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="{{ route('new-sale') }}" class="nav-link px-2 link-secondary">Nova Venda</a></li>
        <li><a href="{{ route('client.index') }}" class="nav-link px-2 link-secondary">Clientes</a></li>
        <li><a href="{{ route('product.index') }}" class="nav-link px-2 link-secondary">Produtos</a></li>
        <li><a href="{{ route('sales.index') }}" class="nav-link px-2 link-secondary">Vendas</a></li>
    </ul>


    <form action="/logout" method="GET">
        @csrf
        <div class="text-end"><button type="submit" class="btn btn-outline-light me-2">Sair</button></div>
    </form>
</div>