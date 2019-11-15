<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$relatorio['tituloRelatorio']}}</title>
    <style>
        table { 
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }
        tr:nth-of-type(odd) { 
            background: #eee; 
        }
        th { 
            background: #28a745 ; 
            color: white; 
            font-weight: bold; 
        }
        td, th { 
            padding: 8px; 
            border: 1px solid #ccc; 
            text-align: center;
            font-size:15px;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: black;
            text-align: center;
        }
        header{
            text-align: center;
            padding: 0em 3px 30px 5px
        }
    </style>
</head>
<body>
    <header>
        <img src="assets/img/logo_SIAF.png" alt="" width="70px">
        <br>
        {{$relatorio['tituloRelatorio']}}
        @if($relatorio['dataRelatorio'])
            <br>
            Período de {{date('d/m/Y', strtotime($relatorio['dataRelatorio']['dataInicio']))}} até  {{date('d/m/Y', strtotime($relatorio['dataRelatorio']['dataFim']))}}
        @endif
        <br>
        Emitido em: {{$relatorio['DataEmissaoRelatorio']->format('d/m/Y - H:i:s')}}
    </header>
    <h4 style="text-align:center;">{{$relatorio['tituloTabelaResumo']}}</h4>
    <table>
        <thead>
            <tr>
                @foreach ($relatorio['colunasTabelaResumo'] as $coluna)
                    <th>{{$coluna}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if (is_array($relatorio['linhasTabelaResumo']))
                <tr>
                    @for ($i = 1; $i <= count($relatorio['linhasTabelaResumo']); $i++)
                        <td>{{$relatorio['linhasTabelaResumo'][$i]}}</td>
                    @endfor
                </tr>
            @else
                @foreach ($relatorio['linhasTabelaResumo'] as $linha)
                <tr>
                    @for ($i = 1; $i <= count($linha->getAttributes()); $i++)
                        @if(date('Y-m-d', strtotime($linha[$i])) == $linha[$i])
                            <td>{{date('d/m/Y', strtotime($linha[$i]))}}</td>
                        @else
                            <td>{{$linha[$i]}}</td>
                        @endif
                    @endfor
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    
    <h4 style="text-align:center;">{{$relatorio['tituloTabelaHistorico']}}</h4>
    
    <table>
        <thead>
            <tr>
                @foreach ($relatorio['colunasTabelaHistorico'] as $coluna)
                    <th>{{$coluna}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($relatorio['linhasTabelaHistorico'] as $linha)
                <tr>
                    @for ($i = 1; $i <= count($linha->getAttributes()); $i++)
                        @if(date('Y-m-d', strtotime($linha[$i])) == $linha[$i])
                            <td>{{date('d/m/Y', strtotime($linha[$i]))}}</td>
                        @elseif($linha[$i] == null)
                            <td>-----</td>
                        @else
                            <td>{{$linha[$i]}}</td>
                        @endif
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Universidade Federal de Mato Grosso do Sul <a href="https://ufms.br/">(UFMS)</a>
    </div>
</body>
</html>



