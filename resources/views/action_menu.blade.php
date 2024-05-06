<style>
    .dropbone {
        position: fixed;
        z-index: 100;
    }

</style>

<div class="align-middle" >
    <button class="btn " type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <svg class="icon " style="width: 20px; height: 20px;">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
        </svg>
    </button>
    <div  class="dropdown dropbone" id="actionMenu">

        <div>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    </div>
</div>
{{--<script>--}}

{{--        var dropdown = document.getElementById('actionMenu');--}}
{{--        dropdown.addEventListener('show.bs.dropdown', function() {--}}
{{--            // Cuando el menú desplegable se abre, aumenta el z-index--}}
{{--            alert("dfd")--}}
{{--            this.style.zIndex = '10000';--}}
{{--        });--}}
{{--        dropdown.addEventListener('hide.bs.dropdown', function() {--}}
{{--            // Cuando el menú desplegable se cierra, restablece el z-index--}}
{{--            alert("df")--}}
{{--            this.style.zIndex = '';--}}
{{--        });--}}
{{--  --}}
{{--</script>--}}
