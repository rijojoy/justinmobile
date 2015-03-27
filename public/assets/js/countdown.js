function countdown() {
        window.setTimeout("countdown()", 1000);

        var bis = new Date();
        var jetzt = new Date();

        if (jetzt.getDay() == 0) { bis.setDate(jetzt.getDate()+1);bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        if (jetzt.getDay() == 1 & jetzt.getHours() < 17 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 1 & jetzt.getHours() == 17 & jetzt.getMinutes() < 30 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 1 & jetzt.getHours() == 17 & jetzt.getMinutes() > 30 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 1 & jetzt.getHours() > 17 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        if (jetzt.getDay() == 2 & jetzt.getHours() < 17 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 2 & jetzt.getHours() == 17 & jetzt.getMinutes() < 30 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 2 & jetzt.getHours() == 17 & jetzt.getMinutes() > 30 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 2 & jetzt.getHours() > 17 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        if (jetzt.getDay() == 3 & jetzt.getHours() < 17 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 3 & jetzt.getHours() == 17 & jetzt.getMinutes() < 30 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 3 & jetzt.getHours() == 17 & jetzt.getMinutes() > 30 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 3 & jetzt.getHours() > 17 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        if (jetzt.getDay() == 4 & jetzt.getHours() < 17 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 4 & jetzt.getHours() == 17 & jetzt.getMinutes() < 30 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 4 & jetzt.getHours() == 17 & jetzt.getMinutes() > 30 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 4 & jetzt.getHours() > 17 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        if (jetzt.getDay() == 5 & jetzt.getHours() < 17 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 5 & jetzt.getHours() == 17 & jetzt.getMinutes() < 30 ) { bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 5 & jetzt.getHours() == 17 & jetzt.getMinutes() > 30 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }
        if (jetzt.getDay() == 5 & jetzt.getHours() > 17 ) { bis.setDate(jetzt.getDate()+1); bis.setHours(12); bis.setMinutes(00); bis.setSeconds(1); }

        if (jetzt.getDay() == 6 & jetzt.getHours() < 12) { bis.setHours(12); bis.setMinutes(00); bis.setSeconds(1); }
        if (jetzt.getDay() == 6 & jetzt.getHours() >= 12) { bis.setDate(jetzt.getDate()+2); bis.setHours(17); bis.setMinutes(30); bis.setSeconds(1); }

        
        var rest = Math.floor((bis-jetzt.getTime())/1000);
        var stunden = 0;
        var minuten = 0;

        if (rest >= 3600) {
                stunden = Math.floor(rest/3600);
                rest -= stunden*3600;
        }

        if (rest >= 60) {
                minuten = Math.floor(rest/60);
                rest -= minuten*60;
        }
        document.getElementById('countdown_div').innerHTML = stunden+' Hours, '+minuten+' Minutes and '+rest+' Seconds';
}