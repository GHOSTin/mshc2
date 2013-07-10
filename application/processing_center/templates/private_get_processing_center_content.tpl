{% extends "ajax.tpl" %}
{% set center = component.centers[0] %}
{% block js %}
    $('.processing-center[processing-center = {{ center.id }}]').append(get_hidden_content());
{% endblock js %}
{% block html %}
    <div class="processing-center-content unstyled">
        {% include '@processing_center/build_processing_center_content.tpl' %}
    </div>
{% endblock html %}