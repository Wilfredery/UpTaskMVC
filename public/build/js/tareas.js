document.querySelector("#agregar-tarea").addEventListener("click",(function(){const e=document.createElement("DIV");e.classList.add("modal"),e.innerHTML='\n        \n            <form class="formulario nueva-tarea">\n                <legend>Agrega una nueva tarea</legend>\n\n                <div class="campo">\n                    <label for="tarea"> Tarea </label>\n\n                    <input \n                    type="text"\n                    name="tarea"\n                    placeholder="Agregar tarea al proyecto actual"\n                    id="tarea"\n                    required\n                    >\n                </div>\n\n                <div class="opciones">\n                    <input class="submit-nueva-tarea" type="submit" value="Agregar tarea">\n\n                    <button class="cerrar-modal" type="button">Cancelar</button>\n                </div>\n            </form>\n        ',setTimeout((()=>{document.querySelector(".formulario").classList.add("animar")}),100),e.addEventListener("click",(function(t){t.preventDefault(),t.target.classList.contains("cerrar-modal")&&(document.querySelector(".formulario").classList.add("cerrar"),setTimeout((()=>{e.remove()}),500)),t.target.classList.contains("submit-nueva-tarea")&&function(){const e=document.querySelector("#tarea").value.trim();""!==e||function(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const r=document.createElement("DIV");r.classList.add("alerta",t),r.textContent=e,a.parentElement.insertBefore(r,a.nextElementSibling),setTimeout((()=>{r.remove()}),3e3)}("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"))}()})),document.querySelector(".dashboard").appendChild(e)}));