{% extends "public.tpl" %}

{% block content %}
<div id="content" class="col-sm-12 full">
  <div class="row">
    <div class="col-md-5">
      <form method="post">
        <h2>Показания счетчиков</h2>
        <div class="form-group">
          <label>Адрес</label>
          <textarea class="form-control" name="address" required></textarea>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>ГВС1</label>
            <input type="text"  class="form-control" name="gvs1">
          </div>
          <div class="form-group col-md-6">
            <label>ГВС2</label>
            <input type="text"  class="form-control" name="gvs2">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>ХВС1</label>
            <input type="text"  class="form-control" name="hvs1">
          </div>
          <div class="form-group col-md-6">
            <label>ХВС2</label>
            <input type="text"  class="form-control" name="hvs2">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Электроэнергия (день)</label>
            <input type="text"  class="form-control" name="electrical1">
          </div>
          <div class="form-group col-md-6">
            <label>Электроэнергия (ночь)</label>
            <input type="text"  class="form-control" name="electrical2">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
        <a href="/" class="btn btn-default">Отменить</a>
      </form>
    </div>
  </div>
</div>
{% endblock content %}

{% block css %}
<link rel="stylesheet" href="/css/default.css">
{% endblock css%}