{% extends "default.tpl" %}

{% block component %}
<div class="col-xs-12 col-sm-2 col-lg-2">
    <h4>Виды отчетов</h4>
    <ul class="list-unstyled">
        <li><a class="get_query_reports">Отчеты по заявкам</a></li>
    </ul>
</div>
<div class="col-xs-12 col-sm-10 col-lg-10 report-content"></div>
{% endblock component %}

{% block javascript %}
    <script src="/js/report.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>
{% endblock javascript %}

{% block css %}
    <link rel="stylesheet" href="/css/datepicker.css" >
{% endblock css %}