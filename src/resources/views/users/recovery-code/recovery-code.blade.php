<p>
    <small>
        Save this recovery code in a secure password manager (LastPass, Bitwarden) or on your notes.
        Use this to access your account in case you lost your phone or the authentication app.
        <br>
        <strong>NOTE: Once recovery code is already used. It will be replaced by new one.</strong>
    </small>
</p>
<ul class="list-group list-group text-center mb-3">
    @foreach (auth()->user()->decryptRecoveryCode() as $recoveryCode)
        <li class="list-group-item">{{ $recoveryCode }}</li>
    @endforeach
</ul>