import * as React from 'react';
import * as ReactDOMClient from 'react-dom/client';
import './Authentication.scss';
import { registerComponent } from '../../component.loader';
import { action, makeObservable, observable } from 'mobx';
import { observer } from 'mobx-react';

const LoginForm : React.FC<{authState: AuthenticationState}> = observer(props => {
    const {authState} = props;
    const [email, setEmail] = React.useState('');
    const [password, setPassword] = React.useState('');
    
    const startRegistration = (event: any) => {
        event.preventDefault();
        authState.isRegistering = true;
    }

    const handleSubmit = async (event: any) => {
        event.preventDefault();
        authState.login(email,password);
    }

    return <>
    {authState.isRegistering && 
        <Registration authState={authState}/>
    }
    {!authState.isRegistering && 
        <form style={{width: '200px'}} >   
            <label className='form-label mt-2' htmlFor="email-input">Email</label>
            <input
                className='form-control'
                value={email}
                type="email"
                onChange={(event)=> setEmail(event.target.value)}
                name="email-input" 
                id="email-input" 
            />
            <label className='form-label mt-2' htmlFor="password-input">Password</label>
            <input 
                required
                className='form-control'
                value={password}
                onChange={(event)=> setPassword(event.target.value)}
                type="password" 
                name="password-input" 
                id="password-input" 
            />
            <button 
                type='submit'
                className='btn btn-primary mt-2'
                onClick={handleSubmit}
            >
                Login
            </button>
            <button
                className='btn btn-primary mt-2'
                onClick={startRegistration}
            >
                Register
            </button>
        </form>
    }
    </>;
});

const LogoutForm : React.FC<{authState: AuthenticationState}> = observer(props => {
    const authState = props.authState
    return <button onClick={authState.logout}>Log Out</button>;
});

const RegisterEmailForm : React.FC<{authState: AuthenticationState}> = observer(props => {

    const authState = props.authState;

    const [email, setEmail] = React.useState('');
    const [emailConfirm, setEmailConfirm] = React.useState('');
    const [isEmailConfirmDisabled, setIsEmailConfirmDisabled] = React.useState(true);
    const [isSubmitButtonDisabled, setIsSubmitButtonDisabled] = React.useState(true);
    

    const handleSubmitEmail = (event: any) => {
        event.preventDefault();
        console.log('made it to here, this will actually be in store');
        
    }

    

    return <form style={{width: '200px'}} >   
        <label className='form-label mt-2' htmlFor="email-input">Email</label>
        <input
            className='form-control'
            value={email}
            type="email"
            onChange={(event) => setEmail(event.target.value)}
            name="email-input" 
            id="email-input" 
        />
        <label className='form-label mt-2' htmlFor="password-input">Confirm Email</label>
        <input
            className='form-control'
            value={emailConfirm}
            type="email"
            onChange={(event) => setEmailConfirm(event.target.value)}
            name="email-input" 
            id="email-input" 
            disabled={isEmailConfirmDisabled}
        />
        <button 
            type='submit'
            className='btn btn-primary mt-2'
            onClick={handleSubmitEmail}
            disabled={isSubmitButtonDisabled}
        >
            Submit Email
        </button>
    </form>;
});

const RegisterPasswordForm : React.FC<{authState: AuthenticationState}> = observer(props => {
    const authState = props.authState;

    const handleSubmit = (event: any) => {
        event.preventDefault();
        
    };

    return <form style={{width: '200px'}} >   
        <label className='form-label mt-2' htmlFor="email-input">Email</label>
        <input
            className='form-control'
            // value={}
            type="email"
            //onChange={}
            name="email-input" 
            id="email-input" 
        />
        <label className='form-label mt-2' htmlFor="password-input">Password</label>
        <input
            className='form-control'
            //value={}
            type="email"
            //onChange={}
            name="email-input" 
            id="email-input" 
        />
        <button 
            type='submit'
            className='btn btn-primary mt-2'
            onClick={handleSubmit}
        >
            Login
        </button>
        <button
            className='btn btn-info mt-2'
        >
            Register
        </button>
    </form>;
});

const Registration : React.FC<{authState: AuthenticationState}> = observer(props => {
    const authState = props.authState;
    return<><RegisterEmailForm authState={authState}/></>;
});

const Authentication : React.FC<{authState: AuthenticationState}> = props => {
    const { authState } = props;
    
    if (authState.isLoggedIn) {
        return <LogoutForm authState={authState}/>
    } else {
        return <LoginForm authState={authState}/>
    }
}

class AuthenticationState {

    @observable
    public isLoggedIn: boolean;

    @observable
    public isRegistering: boolean = false;

    @observable
    public emailToRegister: string|null = null;

    @observable
    public passwordToRegister: string|null = null;

    constructor(isLoggedIn: boolean){
        makeObservable(this);
        this.isLoggedIn = isLoggedIn;
    }

    @action
    public setRegisteringStatus(value: boolean):void {
        this.isRegistering = value;
    }

    public async login(email:string, password:string): Promise<void> {
        const data = {
            "email": email,
            "password": password,
        }
        await fetch('/api/v1/custom/login/verify', {
            method: 'POST',
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data)
        })
        .then(() => {
            window.location.reload()
        })
        .catch(error => console.log(error));
    }

    public async logout(): Promise<void> {
        await fetch('/api/v1/custom/login/logOut', {
            method: 'POST',
            headers: {"Content-Type": "application/json"},
        })
        .then(() => window.location.reload())
        .catch(error => console.log(error));
    }

    public validateEmail(email:string ): boolean {
        const regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
        return regex.test(email)
    }
}

registerComponent('authentication', (element, parameters )=> {
    const { loggedIn } = parameters;
    const authState = new AuthenticationState(loggedIn);
    ReactDOMClient.createRoot(element).render(<Authentication authState={authState}/>);
});