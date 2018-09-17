<div class="sg-table-multi-select">
    <table class="layui-table" id="{{ $id }}" lay-even="true" lay-skin="line" lay-size="sm">
        <thead>
            <tr>
                <th><input class="sg-check-all sg-check-input" type="checkbox" lay-skin="primary"></th>
                <th>名称</th>
            </tr>
        </thead>
        <tbody>
            @if(count($options) <= 0)
                <tr>
                    <td colspan="2">无数据</td>
                </tr>
            @else
            @foreach($options as $option)
                <tr>
                    <td><input class="sg-check-input sg-data-input" type="checkbox" lay-skin="primary" name="{{ $name }}" value="{{ $option['id'] }}" {{ in_array($option['id'], $selected_options) ? 'checked' : '' }}></td>
                    <td>{{ $option['name'] }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<script>
    $(function () {
        $('#{{ $id }} thead').on('click', function () {
            var checked = $('#{{ $id }} .sg-check-all').prop('checked');
            if(checked) {
                $('#{{ $id }} .sg-check-input').prop('checked', true);
                $('#{{ $id }} .layui-form-checkbox').addClass('layui-form-checked');
            } else {
                $('#{{ $id }} .sg-check-input').prop('checked', false);
                $('#{{ $id }} .layui-form-checkbox').removeClass('layui-form-checked');
            }
        });
    })
</script>