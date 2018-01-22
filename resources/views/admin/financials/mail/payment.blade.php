@component('mail::message')
    Olá o pagamento das tarefas em que participaste foi efetuado (PAD: {{$financial->pad}}), se ainda não entregaste o recibo/Ato único por favor responde a este email anexando o mesmo ou entrega diretamente no Centro de Eventos.

    Dados do adquirente do serviço:
    NIF Português - 501413197
    Nome do adquirente do serviço - Universidade do Porto
    Morada Adquirente - PC GOMES TEIXEIRA 4099-002 PORTO

    Passos para emissão de recibo:

    Devem aceder ao site http://www.portaldasfinancas.gov.pt/pt/home.action e autenticarem-se (do lado direito do site).

    Depois devem seguir os seguintes passos:
    > 1 Os Seus Serviços
    > 2 Obter
    > 3 Recibos Verdes Eletrónicos (Faturas-Recibo)
    > 4 Emitir fatura-recibo ato isolado ou recibo verde

    Quando aparecer o recibo para preencherem devem ter a seguinte informação:

    Dados do adquirente do serviço:
    NIF Português - 501413197
    Nome do adquirente do serviço - Universidade do Porto
    Morada Adquirente - PC GOMES TEIXEIRA 4099-002 PORTO

    Dados do serviço:
    Serviço prestado – Hospedeiro ou Técnico apoio a eventos
    Importância - é o valor que têm a receber
    Regime de IVA - continente 23%
    Base de incidência em IRS - descontam se quiserem e no montante que entenderem
    Imposto do Selo – 0€
    Importância recebida - é o valor que têm a receber + os 23% de IVA

    A título de: Honorários

    Data da prestação do serviço : data do fim do contrato

    Alguma dúvida por favor entra em contacto connosco.

    {{ config('app.name') }}
@endcomponent