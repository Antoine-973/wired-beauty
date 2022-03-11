<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Article;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $targetArticle = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($user);
            case self::DELETE:
                return $this->canDelete($user);
        }

        return false;
    }

    private function canEdit(User $user)
    {
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canDelete(User $user){
        if ($this->canEdit($user)) {
            return true;
        }
    }
}
