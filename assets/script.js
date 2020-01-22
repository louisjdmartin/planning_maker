$(document).ready(function() {

    $('.menu-icon').click(function(e) {
        e.preventDefault();
        $this = $(this);
        if ($this.hasClass('menuS')) {
            $('.menu-icon').removeClass('isClosed arrow');
            $('.menu-icon').addClass('isOpen cross');
            a = 1;
            setTimeout(function() {
                $('.menu-icon').addClass('isClosed arrow');
                $('.menu-icon').removeClass('isOpen cross');
            }, 1500)
        } else {
            if ($this.hasClass('isOpen')) {
                $('.menu_open').slideUp(500);
                $('#content').css({
                    "opacity": "1"
                });
                $this.addClass('isClosed');
                $this.removeClass('isOpen');
            } else {
                $('.menu_open').slideDown(500);
                $this.removeClass('isClosed');
                $this.addClass('isOpen');
                $('#content').css({
                    "opacity": ".1"
                });
            }
        }

    });

    $('.menu_open a,.ajax_a').bind("click", function(e) {
        e.preventDefault();
        $('.menu-icon').addClass("loading");
        href = $(this).attr('href');
        $('html,body').scrollTop(0);
        $.post("ajax/" + href, {
            ajax: 1
        }).done(function(data) {
            history.pushState({
                key: href
            }, 'titre', href);
            $('html,body').scrollTop(0);
            $('.menu-icon').removeClass("loading isOpen");
            $('.menu_open').slideUp(500);
            $('.menu-icon').addClass("isClosed");
            $('#content').html(data).css({
                "opacity": "1"
            });
        });
    });
    //history.pushState({key: window.location}, 'titre', window.location);
    window.onpopstate = function(event) {
        $('.menu-icon').removeClass('isClosed arrow');
        $('.menu-icon').addClass('isOpen');
        $('.menu-icon').addClass("loading");
        href = window.location.toString();
        href = href.replace(window.location.pathname, "");
        href = href.replace(window.location.hostname, "");
        href = href.replace("http://", "");
        href = href.replace("https://", "");
        $('html,body').scrollTop(0);
        $.post("ajax/" + href, {
            ajax: 1
        }).done(function(data) {
            $('html,body').scrollTop(0);
            $('.menu-icon').removeClass("loading isOpen");
            $('.menu_open').slideUp(0);
            $('.menu-icon').addClass("isClosed arrow");
            $('#content').html(data).css({
                "opacity": "1"
            });
        });
    }
});


function setDispo(c_id) {
    $('.menu-icon').addClass("loading");
    $.post('ajax/saisie_dispo.php', {
        c_id: c_id,
        dispo: $('#dispo_' + c_id).is(':checked')
    }, function() {
        $('.menu-icon').removeClass("loading");
    });
}

function modifCreneau(id, jour) {
    $('.menu-icon').addClass("loading");
    $.post('ajax/modifCreneau.php', {
        id: id,
        c_deb: $('#c_deb_' + id).val(),
        c_fin: $('#c_fin_' + id).val(),
        affectations: $('#c_aff_' + id).val(),
        c_poids: $('#c_dur_' + id).val(),
        c_jour: jour
    }, function() {
        $('.menu-icon').removeClass("loading");
    });
}

function addCreneau(jour) {
    affectation = $('#c_aff_add_' + jour).val()
    if (affectation < 1 || $('#c_dur_add_' + jour).val() < 0) {
        return;
    }
    $('.menu-icon').addClass("loading");
    $.post('ajax/modifCreneau.php', {
        id: 0,
        c_deb: $('#c_deb_add_' + jour).val(),
        c_fin: $('#c_fin_add_' + jour).val(),
        affectations: affectation,
        c_poids: $('#c_dur_add_' + jour).val(),
        c_jour: jour
    }, function() {
        window.location.reload();
    });
}

function effCreneau(id) {
    $('.menu-icon').addClass("loading");
    $.post('ajax/effCreneau.php', {
        id: id
    }, function() {
        window.location.reload();
    });
}

function modifMbName(id) {
    newname = prompt("Saisir un nom");
    if (newname != undefined) {
        $('.menu-icon').addClass("loading");
        $.post('ajax/editName.php', {
            id: id,
            name: newname
        }, function() {
            window.location.reload();
        });
    }
}

function effMb(id) {
    if (confirm("Confirmer l'action")) {
        $.post('ajax/effmb.php', {
            id: id
        }, function() {
            window.location.reload();
        });
    }
}

function addMb() {
    newname = prompt("Saisir un nom");
    $('.menu-icon').addClass("loading");
    $.post('ajax/addMb.php', {
        name: newname
    }, function() {
        window.location.reload();
    });
}

function modifAffect(c_id, m_id, m_nom) {
    $('#ligne_' + c_id).html("<td colspan='2'><select><option>Remplacer " + m_nom + " par </option><option>Chargement...</option></select></td><td><a href='./?page=temp'>Annuler</a></td>")
    $.post('ajax/getDispo.php', {
        c_id: c_id
    }, function(data) {
        $('#ligne_' + c_id).html("<td colspan='2'><select id='modifDispo' onchange='valideModifAffect(" + c_id + "," + m_id + ")'><option>Remplacer " + m_nom + " par </option>" + data + "</select></td><td><a href='./?page=temp'>Annuler</a></td>");
    });
}

function valideModifAffect(c_id, m_id) {
    $('.menu-icon').addClass("loading");
    $.post('ajax/modifAffect.php', {
        c_id: c_id,
        m_id_old: m_id,
        m_id_new: $('#modifDispo').val()
    }, function() {
        window.location.reload();
    });
}

function cocher(etat) {
    var inputs = document.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
        if (inputs[i].type == 'checkbox')
            inputs[i].checked = etat;
    }
}
