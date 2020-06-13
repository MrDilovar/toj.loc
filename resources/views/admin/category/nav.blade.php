<ul class="list-inline mt-4">
    <li class="list-inline-item"><a class="text-dark" href={{ route('applicant.resume.index') }}>Резюме</a></li>
    <li class="list-inline-item dropdown">
        <div class="dropdown">
            <a href="#" class="dropdown-toggle text-dark" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Образование</a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href={{ route('applicant.education.secondary.index') }}>Среднее образование</a>
                <a class="dropdown-item" href={{ route('applicant.education.higher.index') }}>Высшее образование</a>
            </div>
        </div>
    </li>
    <li class="list-inline-item"><a class="text-dark" href="{{ route('applicant.experience.index') }}">Опыт работы</a></li>
    <li class="list-inline-item"><a class="text-dark" href="{{ route('applicant.skill.index') }}">Навыки</a></li>
    <li class="list-inline-item"><a class="text-dark" href="{{ route('applicant.language.index') }}">Знание языков</a></li>
</ul>
<hr class="mt-3">