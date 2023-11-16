<img src="{{ $image->webp_url ?? $image->url }}" width="{{ $image->width }}" height="{{ $image->height }}" srcset="{{ $image->webp_srcset ?? $image->srcset }}" alt="{{ $image->alt }}">
