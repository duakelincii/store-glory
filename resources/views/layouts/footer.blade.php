<footer class="footer">
    <div class=" container-fluid ">
        <div class="copyright" id="copyright">
            &copy;
            <script>
                document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>
            <a href="{{url('')}}">{{$setting->name}}</a>
        </div>
    </div>
</footer>
