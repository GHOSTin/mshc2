<div class="row">
    <div class="col-md-4">
        <h4>Правила</h4>
        <ul class="list-unstyled">
        {% for rule, status  in profile.rules %}
            <li class="rule" rule="{{ rule }}"><input type="checkbox"{% if status == true %} checked=""{% endif %}> {{ rule }}</li>
        {% endfor %}
        </ul>
    </div>
    <div class="col-md-4">
        <h4>Ограничения</h4>
        <ul class="list-unstyled">
        {% for restriction, status  in profile.restrictions %}
            <li class="restriction" restriction="{{ restriction }}"><div class="get_restriction_content">{{ restriction }}</div></li>
        {% endfor %}
        </ul>
    </div>
</div>