<div>
<style>
    .tracking-detail {
  padding: 3rem 0;
}
#tracking {
  margin-bottom: 1rem;
}
[class*="tracking-status-"] p {
  margin: 0;
  font-size: 1.1rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
}
[class*="tracking-status-"] {
  padding: 1.6rem 0;
}
.tracking-list {
  border: 1px solid #e5e5e5;
}
.tracking-item {
  border-left: 4px solid #00ba0d;
  position: relative;
  padding: 2rem 1.5rem 0.5rem 2.5rem;
  font-size: 0.9rem;
  margin-left: 3rem;
  min-height: 5rem;
}
.tracking-item:last-child {
  padding-bottom: 4rem;
}
.tracking-item .tracking-date {
  margin-bottom: 0.5rem;
}
.tracking-item .tracking-date span {
  color: #888;
  font-size: 85%;
  padding-left: 0.4rem;
}
.tracking-item .tracking-content {
  padding: 0.5rem 0.8rem;
  background-color: #f4f4f4;
  border-radius: 0.5rem;
}
.tracking-item .tracking-content span {
  display: block;
  color: #767676;
  font-size: 13px;
}
.tracking-item .tracking-icon {
  position: absolute;
  left: -0.7rem;
  width: 1.1rem;
  height: 1.1rem;
  text-align: center;
  border-radius: 50%;
  font-size: 1.1rem;
  background-color: #fff;
  color: #fff;
}

.tracking-item-pending {
  border-left: 4px solid #d6d6d6;
  position: relative;
  padding: 2rem 1.5rem 0.5rem 2.5rem;
  font-size: 0.9rem;
  margin-left: 3rem;
  min-height: 5rem;
}
.tracking-item-pending:last-child {
  padding-bottom: 4rem;
}
.tracking-item-pending .tracking-date {
  margin-bottom: 0.5rem;
}
.tracking-item-pending .tracking-date span {
  color: #888;
  font-size: 85%;
  padding-left: 0.4rem;
}
.tracking-item-pending .tracking-content {
  padding: 0.5rem 0.8rem;
  background-color: #f4f4f4;
  border-radius: 0.5rem;
}
.tracking-item-pending .tracking-content span {
  display: block;
  color: #767676;
  font-size: 13px;
}
.tracking-item-pending .tracking-icon {
  line-height: 2.6rem;
  position: absolute;
  left: -0.7rem;
  width: 1.1rem;
  height: 1.1rem;
  text-align: center;
  border-radius: 50%;
  font-size: 1.1rem;
  color: #d6d6d6;
}
.tracking-item-pending .tracking-content {
  font-weight: 600;
  font-size: 17px;
}

.tracking-item .tracking-icon.status-current {
  width: 1.9rem;
  height: 1.9rem;
  left: -1.1rem;
}
.tracking-item .tracking-icon.status-intransit {
  color: #00ba0d;
  font-size: 0.6rem;
}
.tracking-item .tracking-icon.status-current {
  color: #00ba0d;
  font-size: 0.6rem;
}
@media (min-width: 992px) {
  .tracking-item {
    margin-left: 3rem;
  }
  .tracking-item .tracking-date {
    position: absolute;
    left: -10rem;
    width: 7.5rem;
    text-align: right;
  }
  .tracking-item .tracking-date span {
    display: block;
  }
  .tracking-item .tracking-content {
    padding: 0;
    background-color: transparent;
  }

  .tracking-item-pending {
    margin-left: 3rem;
  }
  .tracking-item-pending .tracking-date {
    position: absolute;
    left: -10rem;
    width: 7.5rem;
    text-align: right;
  }
  .tracking-item-pending .tracking-date span {
    display: block;
  }
  .tracking-item-pending .tracking-content {
    padding: 0;
    background-color: transparent;
  }
}

.tracking-item .tracking-content {
  font-weight: 600;
  font-size: 17px;
}

.blinker {
  border: 7px solid #e9f8ea;
  animation: blink 1s;
  animation-iteration-count: infinite;
}
@keyframes blink { 50% { border-color:#fff ; }  }




</style>



    <div class="container py-5">
  <div class="row">

    <div class="col-md-12 col-lg-12">
      <div id="tracking-pre"></div>
        <div id="tracking">
            <div class="tracking-list">


            @foreach($this->data as $item)
            <div class="tracking-item" style="border-left-color:{{ $item['color'] }}">
                <div class="tracking-icon status-current blinker" style="color:{{ $item['color'] }}">
                <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                </svg>
                </div>
                <div class="tracking-content">
                    
                
                <h3 style="color:{{ $item['color'] }}">{{ $item['state'] }}</h3>

                <span style="display:flex; margin-top: 5px;"><svg style="margin-right:5px" width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0055 2H12.9945C14.3805 1.99999 15.4828 1.99999 16.3716 2.0738C17.2819 2.14939 18.0575 2.30755 18.7658 2.67552C19.8617 3.24477 20.7552 4.13829 21.3245 5.23415C21.6925 5.94253 21.8506 6.71811 21.9262 7.62839C22 8.51722 22 9.6195 22 11.0055V12.9945C22 14.3805 22 15.4828 21.9262 16.3716C21.8506 17.2819 21.6925 18.0575 21.3245 18.7658C20.7552 19.8617 19.8617 20.7552 18.7658 21.3245C18.0575 21.6925 17.2819 21.8506 16.3716 21.9262C15.4828 22 14.3805 22 12.9945 22H11.0055C9.6195 22 8.51722 22 7.62839 21.9262C6.71811 21.8506 5.94253 21.6925 5.23415 21.3245C4.13829 20.7552 3.24477 19.8617 2.67552 18.7658C2.30755 18.0575 2.14939 17.2819 2.0738 16.3716C1.99999 15.4828 1.99999 14.3805 2 12.9945V11.0055C1.99999 9.61949 1.99999 8.51721 2.0738 7.62839C2.14939 6.71811 2.30755 5.94253 2.67552 5.23415C3.24477 4.13829 4.13829 3.24477 5.23415 2.67552C5.94253 2.30755 6.71811 2.14939 7.62839 2.0738C8.51721 1.99999 9.61949 1.99999 11.0055 2ZM7.79391 4.06694C7.00955 4.13207 6.53142 4.25538 6.1561 4.45035C5.42553 4.82985 4.82985 5.42553 4.45035 6.1561C4.25538 6.53142 4.13207 7.00955 4.06694 7.79391C4.0008 8.59025 4 9.60949 4 11.05V12.95C4 14.3905 4.0008 15.4097 4.06694 16.2061C4.13207 16.9905 4.25538 17.4686 4.45035 17.8439C4.82985 18.5745 5.42553 19.1702 6.1561 19.5497C6.53142 19.7446 7.00955 19.8679 7.79391 19.9331C8.59025 19.9992 9.60949 20 11.05 20H12.95C14.3905 20 15.4097 19.9992 16.2061 19.9331C16.9905 19.8679 17.4686 19.7446 17.8439 19.5497C18.5745 19.1702 19.1702 18.5745 19.5497 17.8439C19.7446 17.4686 19.8679 16.9905 19.9331 16.2061C19.9992 15.4097 20 14.3905 20 12.95V11.05C20 9.60949 19.9992 8.59025 19.9331 7.79391C19.8679 7.00955 19.7446 6.53142 19.5497 6.1561C19.1702 5.42553 18.5745 4.82985 17.8439 4.45035C17.4686 4.25538 16.9905 4.13207 16.2061 4.06694C15.4097 4.0008 14.3905 4 12.95 4H11.05C9.60949 4 8.59025 4.0008 7.79391 4.06694ZM11.8284 6.75736C12.3807 6.75736 12.8284 7.20507 12.8284 7.75736V12.7245L16.3553 14.0653C16.8716 14.2615 17.131 14.8391 16.9347 15.3553C16.7385 15.8716 16.1609 16.131 15.6447 15.9347L11.4731 14.349C11.085 14.2014 10.8284 13.8294 10.8284 13.4142V7.75736C10.8284 7.20507 11.2761 6.75736 11.8284 6.75736Z" fill="#0F1729"/>
                    </svg>{{ $item['date'] }}</span>
                
                
                <span style="display:flex;margin-top: 5px;"><svg style="margin-right:5px" width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg> {{ $item['user']}}</span></div>
            </div>
    @endforeach




            <div class="tracking-item-pending">
                <div class="tracking-icon status-intransit">
                <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                </svg>
                </div>
                <div class="tracking-content"><span></span></div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>
