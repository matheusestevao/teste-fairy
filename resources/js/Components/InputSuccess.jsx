export default function InputError({ message, className = '', ...props }) {
    return message ? (
        <p {...props} className={'text-sm text-success-600 ' + className}>
            {message}
        </p>
    ) : null;
}
