(function(e){uf_password_checker={init:function(){e("input[name=pass1]").val("").keyup(uf_password_checker.check_pass_strength);e("input[name=pass2]").val("").keyup(uf_password_checker.check_pass_strength);e("#pass-strength-result").show()},check_pass_strength:function(){var t=e("input[name=pass1]").val(),n=e("#user_login").val(),r=e("input[name=pass2]").val(),i;e("#pass-strength-result").removeClass("short bad good strong");if(!t){e("#pass-strength-result").html(uf_vars.strength_indicator);return}i=uf_password_checker.passwordStrength(t,n,r);switch(i){case 2:e("#pass-strength-result").addClass("bad").html(uf_vars.weak);break;case 3:e("#pass-strength-result").addClass("good").html(uf_vars.medium);break;case 4:e("#pass-strength-result").addClass("strong").html(uf_vars.strong);break;case 5:e("#pass-strength-result").addClass("short").html(uf_vars.mismatch);break;default:e("#pass-strength-result").addClass("short").html(uf_vars.very_weak)}},passwordStrength:function(e,t,n){var r=1,i=2,s=3,o=4,u=5,a=0,f,l;if(e!=n&&n.length>0)return u;if(e.length<4)return r;if(e.toLowerCase()==t.toLowerCase())return i;if(e.match(/[0-9]/))a+=10;if(e.match(/[a-z]/))a+=26;if(e.match(/[A-Z]/))a+=26;if(e.match(/[^a-zA-Z0-9]/))a+=31;f=Math.log(Math.pow(a,e.length));l=f/Math.LN2;if(l<40)return i;if(l<56)return s;return o}};e(document).ready(function(e){uf_password_checker.init()})})(jQuery)