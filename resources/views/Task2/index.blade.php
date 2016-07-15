@extends('Task2.app')

@section('content')
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-7">
            <h2>Тестовое задание №2, Сластенов Дмитрий</h2>

            <h3>Перечень пользователей</h3>
              <table class="table table-striped" id="table-ads">
                <thead>
                    <tr>
                        <th style="display: none;">#</th>
                        <th>#</th>
                        <th>имя</th>
                        <th>баланс</th>
                        <th>комментарий</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->balance}}</td>
                        <td>{{$user->text}}</td>
                    </tr>
                  @endforeach

                </tbody>
            </table>

    <h3>Перевод средств</h3>
    
@if( ! empty($error_msg))
<div class="alert alert-danger" role="alert">{{$error_msg}}</div>    
@endif

@if( ! empty($success_msg))
<div class="alert alert-success" role="alert">{{$success_msg}}</div>    
@endif


<form method="post" id="transfer">
    

    <div class="form-group">
        <label for="fld_sender" class="control-label">Отправитель</label>
        <div>
            <select title="Отправитель" name="sender_id" class="form-control" id="fld_sender"> 
                <option value="">-- Выберите отправителя --</option>
                    @foreach($users as $user)
                    <option label="{{$user->name}} {{$user->balance}}" value="{{$user->id}}"></option>
                    @endforeach
            </select> 
        </div>            
    </div>            
  
    <div class="form-group">
        <label for="fld_recipient" class="control-label">Получатель</label>
        <div>
            <select title="Получатель" name="recipient_id" class="form-control" id="fld_recipient"> 
                <option value="">-- Выберите получателя --</option>
                    @foreach($users as $user)
                    <option label="{{$user->name}} {{$user->balance}}" value="{{$user->id}}"></option>
                    @endforeach
                
            </select> 
        </div>            
    </div>            
  
  
    <!--        <input type="text" class="form-control" id="Amount1" placeholder="Amount">-->
  

    <div class="form-group">
        <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
        <div class="input-group">
            <div class="input-group-addon">$</div>
            <input type="text" class="form-control" name="amount" placeholder="Amount">
        </div>
    </div>
  
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <button type="submit" class="btn btn-primary">Выполнить перевод</button>
</form>

  
            <h3>Перечень транзакций</h3>
              <table class="table table-striped" id="table-ads">
                <thead>
                    <tr>
                        <th style="display: none;">#</th>
                        <th>дата время</th>
                        <th>отправитель</th>
                        <th>получатель</th>
                        <th>сумма перевода</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->transact_date}}</td>
                        <td>{{$transaction->sender}}</td>
                        <td>{{$transaction->recipient}}</td>
                        <td>{{$transaction->amount}}</td>
                    </tr>
                  @endforeach

                </tbody>
            </table>


  
        </div>
    </div>
</div>



@stop