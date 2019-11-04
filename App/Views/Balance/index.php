{% extends 'loggedIn.html' %}

{% block body %}

<main>
 <div class="container">
     <article>
        <div class="row text-center">
           <div class="col-sm-8 col-sm-offset-2" style="position: relative;">

           <div class="dropdown calendar_button text-center">
             <button class="btn btn-warning btn-block custom-btn dropdown-toggle" id="calendar_menu" type="button" data-toggle="dropdown">
                 <span class="glyphicon glyphicon-calendar" style="font-size: 30px;"></span>
             </button>
             <div class="dropdown-menu" role="menu" aria-labelledby="calendar_menu" name="calendar_menu">
                 <li role="presentation"><a role="menuitem" tabindex="-1" href="/balance/currentMonth">Bieżący miesiąc</a></li>
                 <li role="presentation"><a role="menuitem" tabindex="-1" href="/balance/previousMonth">Poprzedni miesiąc</a></li>
                 <li role="presentation"><a role="menuitem" tabindex="-1" href="/balance/currentYear">Bieżący rok</a></li>
                 <li role="presentation"><a role="menuitem" tabindex="-1" href="#choose_date_modal" data-toggle="modal">Wybierz okres</a></li>
             </div>
           </div>

           <div class="modal fade" id="choose_date_modal" tabindex="-1" role="dialog" aria-labelledby="choose_date_label" aria-hidden="true">
             <div class="modal-dialog" role="document">

                 <div class="modal-content">

                     <div class="modal-header">
                          <h2 class="modal-title" id="choose_date_label">Wybierz okres</h2>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                          </button>
                     </div>

                    <form method="POST" action="/balance/index">
                    <div class="modal-body">

                       <div class="form-group">
                           <label for="date_from">Data od </label>
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-hourglass"></i></span>
                                <input id="date_from" type="date" class="form-control" name="date_from">
                             </div>
                       </div>

                       <div class="form-group">
                           <label for="date_to">Data do </label>
                             <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-hourglass"></i></span>
                                <input id="date_to" type="date" class="form-control" name="date_to">
                             </div>
                       </div>

                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                       <button type="submit" class="btn btn-success">Zapisz</button>
                    </div>
                    </form>
                 </div>
             </div>
           </div>

           <h1><b>Bilans </b></h1>

           Okres:

           {% if choosenDatePeriod == 'current_month' %}
               Bieżący miesiąc
           {% elseif choosenDatePeriod == 'previous_month' %}
               Poprzedni miesiąc
           {% elseif choosenDatePeriod == 'current_year' %}
               Bieżący rok
           {% elseif choosenDatePeriod == 'date_period' %}
               Od {{ dateFrom }} do {{ dateTo }}
           {% endif %}

           {% for income in incomes %}
               <div class="row income">
                  <div class="col-sm-1" style="margin-top: 20px;">
                  <div style="font-size: 40px;"><span class="glyphicon glyphicon-plus"></span></div>
                  </div>

                  <div class="col-sm-2" style="margin-top: 27px;">
                  <div style="font-size: 25px;"><b>{{ income[0] }}</b></div>
               </div>
              {% if income[3] == '' %}
                 <div class="col-sm-6">
                    <div  style="font-size: 22px; margin-top: 28px;"><b>{{ income[1] }}</b></div>
                 </div>
               {% else %}
                  <div class="col-sm-6">
                      <div  style="font-size: 22px; margin-top: 15px;"><b>{{ income[1] }}</b></div>
                      <div  style="font-size: 15px; margin-top: 5px;">{{ income[3] }}</div>
                  </div>
               {% endif %}
                  <div class="col-sm-2" style="margin-top: 32px;">
   						<div style="font-size: 18px;">{{ income[2] }}</div>
   					</div>

   					<div class="col-sm-1" style="margin-top: 15px;">
   						<span class="glyphicon glyphicon-pencil"></span>
   						<span class="glyphicon glyphicon-trash"></span>
   					</div>
   				</div>
           {% endfor %}


           {% for expense in expenses %}
           <div class="row expense">
             <div class="col-sm-1" style="margin-top: 20px;">
                <div style="font-size: 40px;"><span class="glyphicon glyphicon-minus"></span></div>
             </div>

             <div class="col-sm-2" style="margin-top: 27px;">
                <div style="font-size: 25px;"><b>{{ expense[0] }}</b></div>
             </div>
             {% if expense[4] == '' %}
             <div class="col-sm-6">
					<div  style="font-size: 22px; margin-top: 10px;"><b>{{ expense[1] }}</b></div>
					<div  style="font-size: 18px; margin-top: 5px;">{{ expense[2] }}</div>
				</div>
             {% else %}
             <div class="col-sm-6">
   					<div  style="font-size: 22px; margin-top: 5px;"><b>{{ expense[1] }}</b></div>
   					<div style="font-size: 18px;">{{ expense[2] }}</div>
   					<div  style="font-size: 12px; margin-top: 5px;">{{ expense[4] }}</div>
			    </div>
             {% endif %}
             <div class="col-sm-2" style="margin-top: 32px;">
   					<div style="font-size: 18px;">{{ expense[3] }}</div>
   				</div>

   				<div class="col-sm-1" style="margin-top: 15px;">
   					<span class="glyphicon glyphicon-pencil"></span>
   					<span class="glyphicon glyphicon-trash"></span>
   				</div>
   			</div>
          {% endfor %}

				<br/> Bilans za wybrany okres wynosi: <b>{{ balance }}</b><br/>
            {% if balance > 0 %}
                  <div style="color: green; font-size: 25px;"><b>Gratulacje, świetnie zarządzasz finansami!</b></div>
            {% elseif balance <= 0 %}
                  <div style="color: red; font-size: 25px;"><b>Czas zacząć oszczędzać</b></div>
            {% endif %}

            <script>
               window.onload = function()
               {
                  var chart = new CanvasJS.Chart("chartContainer",
                  {
                        animationEnabled: true,
                        title: {
                           text: "Kategorie wydatków"
                        },
                        data: [{
                           type: "pie",
                           yValueFormatString: "#,##0.00\" PLN\"",
                           indexLabel: "{label} ({y})",
                           dataPoints: '{{ dataChart }}'
                         }]
                  });
                  chart.render();
               }
            </script>

            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

          </div>
       </div>
     </article>
   </div>
</main>

{% endblock %}
