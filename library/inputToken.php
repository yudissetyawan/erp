    <style type="text/css">
    body { font-family: Arial, Helvetica; margin: 20px; }
    </style>

    <script type="text/javascript" charset="utf-8">
    $(function() {
      var data = [
        { id : 1 , label : 'Superman'        , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 2 , label : 'Ironman'         , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 3 , label : 'Batman'          , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 4 , label : 'Thor'            , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 5 , label : 'Hulk'            , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 6 , label : 'Wolverine'       , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 7 , label : 'Captain America' , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 8 , label : 'Spiderman'       , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        { id : 9 , label : 'Robin'           , email : 'test@example.org' , image : 'http://lorempixel.com/100/100' } ,
        ] ; 

        function log(token, level, data) {
          $('#logs').text($('#logs').text() + '\n' + level + ' --- ' + token + '---' +  data);
        };

        var tokenizer = new $.pmTokenizer($('#inputToken'), {source : data,
          // labelHandler handles html to show in autocomplete
          labelHandler : function(data) {
            var template = _.template('\
            <img src="<%= image %>" />\
            <span class="name"><%= label %></span>\
            <span class="email"><%= email %></span>\
            ');
            return template(data);
          },
          tokenHandler : function(data) {
            var template = _.template('\
            <%= _.isString(data) ? data : data.label %>\
            ');
            return template({data : data});
          },
        });
    });
    </script>
  <input type="text" id="inputToken" />

  <textarea cols="100" rows="40" id="logs" readonly="readonly"></textarea>

