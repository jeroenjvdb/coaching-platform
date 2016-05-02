<h2>contact</h2>
<div class="row swimmer contact">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <strong>phone:</strong>
            </div>
            <div class="col-md-8">
                {{ $swimmer->phone }}
            </div>
            <div class="col-md-4">
                <strong>email:</strong>
            </div>
            <div class="col-md-8">
                {{ $swimmer->email }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <strong>email ouders:</strong>
            </div>
            <div class="col-md-8">
                {{ $swimmer->parent1 }} </br>
                {{ $swimmer->parent2 }}
            </div>
        </div>
    </div>
</div>