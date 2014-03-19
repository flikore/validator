function generateList(element)
{
    var html='<div id="ulmenu"><ul class="nav nav-list">';
    
    var lastLevel = 'h2';

    element.find('h2,h3,h4').each(function(index, value){
        var thisLevel = value.nodeName.toLowerCase();
        
        if(thisLevel <= lastLevel)
        {
            html +='</li>\n';
        }
        
        if(thisLevel > lastLevel)
        {
            html+='<ul class="nav">\n';
        }
        else if(thisLevel < lastLevel)
        {
            html +='</ul></li>\n';
        }
                
        html += '<li><a href="#' + $(value).attr('id') + '" class="level-'+ thisLevel +'">'+ $(value).html() + '</a>';
        
        lastLevel = thisLevel;
    });
    
    html +='</li>\n';
    
    if(lastLevel > 'h2')
    {
        html +='</ul></li>\n';
    }
    
    html += '</ul>';
    html += '<a href="#top">Back to top</a>';
    html += '</div>';

    return html;
}

$(document).ready(function(){
    $('#toc')
        .html(generateList($('#main')))
        .affix({
                offset: {
                    top: 50,
                    bottom: $('#bottom').outerHeight(true)
        }});
    
    $('[data-spy="scroll"]').each(function () {
      var $spy = $(this).scrollspy('refresh')
    })
});