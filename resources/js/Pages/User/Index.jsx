import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import NavLink from '@/Components/NavLink';

export default function UserIndex({ auth, order_by_salary_asc }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Funcionários</h2>}
        >
            <Head title="Funcionários" />
            

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <NavLink href={route('users.import')} className='mb-3 bg-green-300 btn'>
                        Importar Arquivo
                    </NavLink>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table className="w-full bg-white divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salário <small>(R$)</small></th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempo de Empresa <small>(dias)</small></th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {order_by_salary_asc.map((employee, index) => (
                                    <tr key={employee.id}>
                                        <td className="px-6 py-4 whitespace-nowrap">{index + 1}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{employee.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{employee.email}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            {employee.occupation_actual.map((occupation) => (
                                                <span key={occupation.id}>{occupation.name}</span>
                                            ))}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">{parseFloat(employee.salary).toFixed(2)}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{employee.time_service}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
