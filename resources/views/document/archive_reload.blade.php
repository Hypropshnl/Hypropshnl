@include('document.data', ['mainData' => $mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>