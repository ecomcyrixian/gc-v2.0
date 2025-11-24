
<form action="#" method="POST" enctype="multipart/form-data">

    <span>
        <label for="gc-name">Full Name</label>
        <input type="text" name="name" id="gc-name" placeholder="" required/>
    </span>

    <span>
        <label for="gc-email">Work email</label>
        <input type="email" name="email" id="gc-email" placeholder="" required/>
    </span>
    
    <span>
        <label for="gc-phone">Phone</label>
        <input type="text" name="phone" id="gc-phone" placeholder="" required/>
    </span>

    <span>
        <label for="gc-company">Company</label>
        <input type="text" name="company" id="gc-company" placeholder="" required/>
    </span>
    
    <span>
        <label for="gc-people-hire">How many hires in the next 12 months?</label>
        <div class="custom-select">
            <select name="people-hire" id="gc-people-hire" required>
                <option>1 - 10</option>
                <option>11 - 20</option>
                <option>21- 30</option>                                    
            </select>
            <div class="select-arrow"></div>
        </div>
    </span>

    <span>
        <label for="gc-message">Your message <i>(optional)</i></label>
        <textarea name="" id=""></textarea>
    </span>
    <span>
        <div class="formcarry-block">  
            <button class="button btn blue" type="submit">Send</button>
        </div>
    </span>

</form>
