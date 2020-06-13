<div class="hmenu">
    <div class="hmenu-catalog my-3">
        <ul class="hmenu-catalog-nav" data-menu-id="0">
            <li>
                <div class="hmenu-catalog-nav-item title">Все категории</div>
            </li>
            @foreach($categories->getIndexCategories() as $category)
                <li>
                    @if(!$category->children->isEmpty())
                        <a href class="hmenu-catalog-nav-item next-item" data-next-menu-id="{{ $category->id }}" data-menu-id="0">
                            <div>{{ $category->name }}</div>
                            <i class="ti-angle-right"></i>
                        </a>
                    @else
                        <a href="{{ route('guest.categories', $category->get_full_slug()) }}" class="hmenu-catalog-nav-item">{{ $category->name }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
        @foreach($categories->all() as $category)
            @if(!$category->children->isEmpty())
                <ul class="hmenu-catalog-nav" data-menu-id="{{ $category->id }}">
                    <li>
                        <a href class="hmenu-catalog-nav-item title prev-item" data-menu-id="{{ $category->id }}" data-prev-menu-id="{{ $category->parent ? $category->parent->id : 0 }}">
                            <i class="ti-angle-left"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                        <hr class="my-0">
                    </li>
                    <li>
                        <a href="{{ route('guest.categories', $category->get_full_slug()) }}" class="hmenu-catalog-nav-item">Все</a>
                    </li>
                    @foreach($category->children as $children)
                        <li>
                            @if(!$children->children->isEmpty())
                                <a href class="hmenu-catalog-nav-item next-item" data-menu-id="{{ $category->id }}" data-next-menu-id="{{ $children->id }}">
                                    <div>{{ $children->name }}</div>
                                    <i class="ti-angle-right"></i>
                                </a>
                            @else
                                <a href="{{ route('guest.categories', $children->get_full_slug()) }}" class="hmenu-catalog-nav-item">{{ $children->name }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </div>
</div>
