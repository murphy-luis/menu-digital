<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <span class="badge badge-pill bg-primary float-right">{{Cart::instance($table_name)->content()->count()}}</span>
        <strong>Comanda</strong>
    </li>
    <li style="list-style-type: none;">
        <div class="default-collapse collapse-bordered">
            <div class="card collapse-header">
                @foreach (Cart::instance($table_name)->content()->groupBy('options.diner_id') as $content)
                    <div id="headingdiner{{$content[0]->options->diner_id}}" class="card-header" data-toggle="collapse" role="button" data-target="#diner{{$content[0]->options->diner_id}}" aria-expanded="false" aria-controls="diner{{$content[0]->options->diner_id}}">
                        <span class="lead collapse-title">
                            @php
                                $diner = \App\Diner::findOrFail($content[0]->options->diner_id);
                            @endphp
                            {{$diner->diner_nickname}}
                        </span>
                    </div>
                    
                    
                    <div id="diner{{$content[0]->options->diner_id}}" role="tabpanel" aria-labelledby="headingdiner{{$content[0]->options->diner_id}}" class="collapse">
                        <div class="card-content">
                            <div class="card-body">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                Nombre
                                            </th>
                                            <th>
                                                Cantidad
                                            </th>
                                            <th>
                                                Precio
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $command)
                                            <tr>
                                                <td>
                                                    <strong>{{$command->name}}</strong>
                                                    <br>
                                                    <small>{{$command->options->comments}}</small>
                                                </td>
                                                <td>{{$command->qty}}</td>
                                                <td>${{number_format($command->price,2,'.',',')}}</td>
                                                <td>
                                                    <i class="fa fa-trash" onclick="delete_item('{{$command->rowId}}_{{$table_name}}',)"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                
            </div>
        </div>
    </li>
</ul>

<ul class="list-group list-group-flush">
    <!--Por si no funciona lo de arriba-->
    {{-- <li class="list-group-item">
        <span class="badge badge-pill bg-primary float-right">{{Cart::instance($table_name)->content()->count()}}</span>
        <strong>Comanda</strong>
    </li>
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>
                    Nombre
                </th>
                <th>
                    Cantidad
                </th>
                <th>
                    Precio
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach (Cart::instance($table_name)->content(); as $content)
                <tr>
                    <td>
                        <strong>{{$content->name}}</strong>
                        <br>
                        <small>{{$content->options->comments}}</small>
                    </td>
                    <td>{{$content->qty}}</td>
                    <td>${{number_format($content->price,2,'.',',')}}</td>
                    <td>
                        <i class="fa fa-trash" onclick="delete_item('{{$content->rowId}}_{{$table_name}}',)"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
    <li class="list-group-item" align="right">
        Subtotal : ${{number_format(str_replace(",","",Cart::instance($table_name)->subtotal()),2,'.',',')}}
    </li>
    <li class="list-group-item" align="right">
        Total : ${{number_format(str_replace(",","",Cart::instance($table_name)->total()),2,'.',',')}}
    </li>
    <li class="list-group-item">
        <form action="{{ route('menu-table-diners.store') }}" method="POST">
            @csrf
            <input type="hidden" name="menu_table_diner" value="{{$table_name}}">
            <button class="btn btn-success btn-block">
                <i style="font-size: 40px" class="fa fa-caret-right"></i> <strong style="font-size: 40px"> &nbsp &nbsp Ordenar </strong>
            </button>
        </form>
    </li>
</ul>

<script type="text/javascript">
    function delete_item(id) {
        $.ajax({
            url: '/admin/table-products/'+id,
            type: 'DELETE',
            data:{'_token' : '{{csrf_token()}}' },
            success:function(result) {
                $('#list_commands').html(result);
            }
        });
    }
</script>