<x-layout>
    <x-slot:title>{{$category->name}}</x-slot:title>
    <livewire:category-services :categorySlug="$category->slug" />
</x-layout>
