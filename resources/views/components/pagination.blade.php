<div>
    @if ($paginator->hasPages())
        <div class="mt-4">
            {{ $paginator->links() }}
        </div>
    @endif

</div>